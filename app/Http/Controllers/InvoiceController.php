<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use App\Model\Orders;
use App\Http\Requests;
use App\Model\Sales;
use App\Model\Shipment;
use App\Model\Deposit;
use App\Http\Start\Helpers;
use DB;
use PDF;
use Session;

class InvoiceController extends Controller
{
    public function __construct(Orders $orders,Sales $sales,Shipment $shipment,EmailController $email, Deposit $deposit){

        $this->order = $orders;
        $this->sale = $sales;
        $this->shipment = $shipment;
        $this->email = $email;
        $this->deposit = $deposit;
    }

    /**
    * Preview of Invoice details
    * @params order_no, invoice_no
    **/

    public function viewInvoiceDetails($orderNo,$invoiceNo){



        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice';

       $verficar= $data['saleDataOrder'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        if($verficar!=null){
             $data['invoiceType'] = $data['saleDataOrder']->invoice_type;     
        }

       
       $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $invoiceNo)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->select("sales_orders.*","location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();   
      



        $data['invoiceData'] = $this->order->getSalseOrderByID($invoiceNo,$data['saleDataInvoice']->from_stk_loc);
       
        
          $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.debtor_no','=','debtors_master.debtor_no')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                             ->first();
        //d($data['customerInfo'],1);

        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no')->first();

        $data['payments']   = DB::table('payment_terms')->get();
       
        if($verficar!=null){
        $data['paymentsList'] = DB::table('payment_history')
                                ->where(['order_reference'=>$data['orderInfo']->reference])
                                ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                                ->select('payment_history.*','payment_terms.name')
                                ->orderBy('payment_date','DESC')
                                ->get();
        }
                                
        $data['invoice_no'] = $invoiceNo;
        
        $data['invoiced_status'] = 'yes';
        $data['invoiced_date'] = $data['saleDataInvoice']->ord_date;

        $lang = Session::get('dflt_lang');
        $data['emailInfo'] = DB::table('email_temp_details')->where(['temp_id'=>4,'lang'=>$lang])->select('subject','body')->first();
        $data['due_date']  = formatDate(date('Y-m-d', strtotime("+".$data['saleDataInvoice']->days_before_due."days")));
        //d( $data['saleDataInvoice'] ,1);
        
        $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');


                $invoice_count = DB::table('payment_history')->count();
                if($invoice_count>0){
            $invoiceReference = DB::table('payment_history')->select('reference')->orderBy('id','DESC')->first();

                   $ref = explode("-",$invoiceReference->reference);
                   $data['invoice_count'] = (int) $ref[1];
                }else{
                   $data['invoice_count'] = 0 ;
                }
        

            $id = $data['customerInfo']->debtor_no;
            $dt = date("Y/m/d");
            $parte_ano = substr($dt,  0, 4);
            $data['nuit'] = DB::table('cust_branch')->where('debtor_no','=',$id)->first()->nuit;
            $data['nuit_company'] = DB::table('preference')->where('id','=','20')->first()->value;
            $data['parte_ano'] =$parte_ano;
    
            return view('admin.invoice.viewInvoiceDetails', $data);
    }
    


    
    /**
    * Send email to customer for Invoice information
    */
    public function sendInvoiceInformationByEmail(Request $request){

        $orderNo = $request['order_id'];
        $invoiceNo = $request['invoice_id'];
        $invoiceName = 'invoice_'.time().'.pdf';
        
        if(isset($request['invoice_pdf']) && $request['invoice_pdf']=='on'){
            $this->invoicePdfEmail($orderNo,$invoiceNo,$invoiceName);
            $this->email->sendEmailWithAttachment($request['email'],$request['subject'],$request['message'],$invoiceName);
         }else{
            $this->email->sendEmail($request['email'],$request['subject'],$request['message']);
         }   
        
        Session::flash('success',trans('message.email.email_send_success'));
        return redirect()->intended('invoice/view-detail-invoice/'.$orderNo.'/'.$invoiceNo);

    }
    

    // Email Auto by sh@dy

     public function sendInvoiceInformationByEmailMany(Request $request){

        $orderNo = $request['order_id'];
        $invoiceNo = $request['invoice_id'];
        $invoiceName = 'invoice_'.time().'.pdf';
        
        /* $data['facturas'] = DB::table('sales_orders')
                    ->where('order_no', '=', $invoiceNo)
                    ->select("sales_orders.*")
                    ->get();
        */
                    

        if(isset($request['invoice_pdf']) && $request['invoice_pdf']=='on'){
          return  $this->invoicePdfEmail($orderNo,$invoiceNo,$invoiceName);
            $this->email->sendEmailWithAttachment('albertomatsinhe@gmail.com','Alerta de combranca','Caro cliente desejamos que salde as suas dividas',$invoiceName);
         }else{
            $this->email->sendEmail($request['email'],$request['subject'],$request['message']);
         }   
        
        Session::flash('success',trans('message.email.email_send_success'));
        return redirect()->intended('invoice/view-detail-invoice/'.$orderNo.'/'.$invoiceNo);

    }
    










    /**
    * Invoice print
    */
    public function invoicePrint($orderNo,$invoiceNo){

        
        $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $invoiceNo)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->select("sales_orders.*","location.location_name",'invoice_payment_terms.days_before_due')
                    ->first(); 
       // d($data['saleDataInvoice'],1);                   
        $data['invoiceData'] = $this->order->getSalseOrderByID($invoiceNo,$data['saleDataInvoice']->from_stk_loc);

        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.debtor_no','=','debtors_master.debtor_no')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                             ->first();
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no')->first();
        $data['due_date']  = formatDate(date('Y-m-d', strtotime("+".$data['saleDataInvoice']->days_before_due."days")));
        $pdf = PDF::loadView('admin.invoice.invoicePrint', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('invoice_'.time().'.pdf',array("Attachment"=>0));        
    }

    /**
    * Generate pdf for invoice
    */
    public function invoicePdf($orderNo,$invoiceNo){

        $data['taxInfo'] = $this->sale->calculateTaxRow($invoiceNo);
        $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $invoiceNo)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->select("sales_orders.*","location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();                    
        $data['invoiceData'] = $this->order->getSalseOrderByID($invoiceNo,$data['saleDataInvoice']->from_stk_loc);

        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.debtor_no','=','debtors_master.debtor_no')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                             ->first();
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no')->first();
        $data['due_date']  = formatDate(date('Y-m-d', strtotime("+".$data['saleDataInvoice']->days_before_due."days")));
        
        $pdf = PDF::loadView('admin.invoice.invoicePrint', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('invoice_'.time().'.pdf',array("Attachment"=>0));        
    }

    public function destroy($id)
    {
        
        if(isset($id)) {
            $record = \DB::table('sales_orders')->where('order_no', $id)->first();
            if($record) {
                
                $invoice_id = $id;
                $order_id = $record->order_reference_id;
                $invoice_reference = $record->reference;
                $order_reference = $record->order_reference;

                DB::table('sales_orders')->where('order_no', '=', $invoice_id)->delete();
                DB::table('sales_order_details')->where('order_no', '=', $invoice_id)->delete();
                DB::table('stock_moves')->where('reference', '=', 'store_out_'.$invoice_id)->delete();
                DB::table('payment_history')->where('invoice_reference', '=', $invoice_reference)->delete();

                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('sales/list');
            }
        }
    }
    public function invoicePdfEmail($orderNo,$invoiceNo,$invoiceName){

        $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $invoiceNo)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->select("sales_orders.*","location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();                    
        $data['invoiceData'] = $this->order->getSalseOrderByID($invoiceNo,$data['saleDataInvoice']->from_stk_loc);

        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                             ->first();
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no')->first();
        $data['due_date']  = formatDate(date('Y-m-d', strtotime("+".$data['saleDataInvoice']->days_before_due."days")));
        $pdf = PDF::loadView('admin.invoice.invoicePdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->save(public_path().'/uploads/invoices/'.$invoiceName);        
    }

}
