<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\CustomerPayment;
//use App\Model\Payment;
use Omnipay\Omnipay;
use Validator;
use DB;
use Session;
use Auth;
use Image;

class CustomerPayController extends Controller
{

    public function __construct(CustomerPayment $payment){
          $this->payment = $payment; 
    }

   /**
    * Payment list
    */
    public function payNow(Request $request){

        $orderno = base64_decode($request->ord);
        $invoiceno = base64_decode($request->inv);
        $paymentMethod = $request->method;
        $invoice = $this->payment->invoiceInformation($orderno,$invoiceno);
        
        if($paymentMethod != 1){
            $data['orderno'] = $orderno;
            $data['invoiceno'] = $invoiceno;
            $data['paymentMethod'] = $request->method;
            $data['amount'] = ($invoice->total-$invoice->paid_amount);

            return view('admin.customerPanel.pay_bank', $data);
        }

        
        $paypal_credentials = DB::table('payment_gateway')->where('site', 'PayPal')->get();
        
        $amount = number_format(($invoice->total-$invoice->paid_amount), 2, '.', ''); 
        
        $purchaseData   =   [
                            'testMode'  => ($paypal_credentials[3]->value == 'sandbox') ? true : false,
                            'amount'    => $amount,
                            'currency'  => 'USD',
                            'returnUrl' => url('customer_payments/success'),
                            'cancelUrl' => url('customer_payments/cancel')
                            ];
        //d($purchaseData,1);

        Session::put('order_no', $orderno);
        Session::put('invoice_no', $invoiceno);
        Session::put('payment_method', $paymentMethod);
        Session::put('amount', $amount);        
        Session::save();
        
        $this->setup();   

        if($amount>0) {

            $response = $this->omnipay->purchase($purchaseData)->send();
        // d($response->getMessage(),1);
            // Process response
            if ($response->isSuccessful())
            {
                // Payment was successful
                $this->paymentSuccess();

            } 
            elseif ($response->isRedirect()) 
            {
                // Redirect to offsite payment gateway
                $response->redirect();
            } 
            else 
            {
                // Payment failed
                 Session::flash('error','Payment not successful');
                return redirect('customer-panel/view-detail-invoice/'.$orderno.'/'.$invoiceno);
            }
        }
          
    }

    public function paymentSuccess(){

        $order_no = Session::get('order_no');
        $invoice_no = Session::get('invoice_no');

        $invoiceInfo = DB::table('sales_orders')->where('order_no',$invoice_no)->first();
        $accountInfo = DB::table('bank_accounts')->where('default_account',1)->first();

        $transaction = [];
        
        $amount = ($invoiceInfo->total-$invoiceInfo->paid_amount);

        $transaction['amount'] = $amount;
        $transaction['trans_type'] = 'cash-in-by-sale';
        $transaction['account_no'] =  $accountInfo->id;
        $transaction['trans_date'] = date('Y-m-d');
        $transaction['person_id'] = 1;
        $transaction['description'] = 'Payment for '.$invoiceInfo->reference.' on paypal';
        $transaction['category_id'] = 1;
        $transaction['payment_method'] = 1;
        $transaction['created_at'] = date('Y-m-d H:i:s');

        $transactionId = DB::table("bank_trans")->insertGetId($transaction);

        // Payment Table
        $payment['transaction_id'] = $transactionId;
        $payment['invoice_reference'] = $invoiceInfo->reference;
        $payment['order_reference'] = $invoiceInfo->order_reference;
        $payment['payment_type_id'] = Session::get('payment_method');
        $payment['amount'] =  $amount;
        $payment['payment_date'] = date('Y-m-d');
        $payment['person_id'] = 1; 
        $payment['customer_id'] = $invoiceInfo->debtor_no; 
        $payment['created_at'] = date('Y-m-d H:i:s');
         
        $payment = DB::table('payment_history')->insertGetId($payment);
       
        $paidAmount = $this->payment->updatePayment($invoiceInfo->reference,$amount);
        Session::flash('message','Payment successful');
        return redirect()->intended('customer-panel/view-detail-invoice/'.$order_no.'/'.$invoice_no);
        

    }
    public function paymentCancel()
    {
        $order_no = Session::get('order_no');
        $invoice_no = Session::get('invoice_no');

        Session::flash('error','You have canceled your payment');
        return redirect()->intended('customer-panel/view-detail-invoice/'.$order_no.'/'.$invoice_no);
    }

    /**
     * Setup the Omnipay PayPal API credentials
     *
     * @param string $gateway  PayPal Payment Gateway Method as PayPal_Express/PayPal_Pro
     * PayPal_Express for PayPal account payments, PayPal_Pro for CreditCard payments
     */
    public function setup($gateway = 'PayPal_Express')
    {
        // Get PayPal credentials from payment_gateway table
        $paypal_credentials = DB::table('payment_gateway')->where('site', 'PayPal')->get();

        // Create the instance of Omnipay
        $this->omnipay  = Omnipay::create($gateway);

        $this->omnipay->setUsername($paypal_credentials[0]->value);
        $this->omnipay->setPassword($paypal_credentials[1]->value);
        $this->omnipay->setSignature($paypal_credentials[2]->value);
        $this->omnipay->setTestMode(($paypal_credentials[3]->value == 'sandbox') ? true : false);
        if($gateway == 'PayPal_Express')
            $this->omnipay->setLandingPage('Login');
    }

    public function bankPayment(Request $request){
        $invoice_no = $request->invoice_no;
        $order_no = $request->order_no;
        $amount = $request->amount;
        $method = $request->method;

        $invoiceInfo = DB::table('sales_orders')->where('order_no',$invoice_no)->first();
        $accountInfo = DB::table('bank_accounts')->where('default_account',1)->first();

        $transaction['amount'] = $amount;
        $transaction['trans_type'] = 'cash-in-by-sale';
        $transaction['account_no'] =  $accountInfo->id;
        $transaction['trans_date'] = date('Y-m-d');
        $transaction['person_id'] = 1;
        $transaction['description'] = 'Payment for '.$invoiceInfo->reference;
        $transaction['category_id'] = 1;
        $transaction['payment_method'] = $method;
        $transaction['created_at'] = date('Y-m-d H:i:s');

        $attachment = $request->attachment;
        if(!empty($attachment)){
           $attachmentName = time().'.'.$attachment->getClientOriginalExtension();
           //Move Uploaded File
           $destinationPath = 'uploads/attachment';
           $attachment->move($destinationPath, $attachmentName);

          $transaction['attachment'] = $attachmentName;
        }
        //d($data,1);
        $transactionId = DB::table("bank_trans")->insertGetId($transaction);

        // Payment Table
        $payment['transaction_id'] = $transactionId;
        $payment['invoice_reference'] = $invoiceInfo->reference;
        $payment['order_reference'] = $invoiceInfo->order_reference;
        $payment['payment_type_id'] = $method;;
        $payment['amount'] =  $amount;
        $payment['payment_date'] = date('Y-m-d');
        $payment['person_id'] = 1; 
        $payment['customer_id'] = $invoiceInfo->debtor_no; 
        $payment['status'] = 'pending'; 
        $payment['created_at'] = date('Y-m-d H:i:s');
         
        $payment = DB::table('payment_history')->insertGetId($payment);
       
        $paidAmount = $this->payment->updatePayment($invoiceInfo->reference,$amount);
        Session::flash('message','Payment successful');
        return redirect()->intended('customer-panel/view-detail-invoice/'.$order_no.'/'.$invoice_no);
    }

}