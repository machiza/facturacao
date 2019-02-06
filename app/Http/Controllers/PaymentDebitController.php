<?php

namespace App\Http\Controllers;

//Hugo
if(isset($_POST["btn_pagar_debito"])){
    require_once './conexao.php';

    $id_deb = $_POST ["debit_no_id"];
    $amount = $_POST ["amount"];

    $referencia = $_POST["invoice_reference"];
    
    $sql = "Select * from sales_debito where debit_no = '$id_deb'";
    $comando = $pdo->prepare($sql);
    $comando->execute();
    $t = $comando->fetch();
    $saldo_default = $t["paid_amount_debit"];

if($saldo_default = 0){

    //update pending:
    $sql_paid_doc = "update sales_pending set amount_paid_pending = :paid where reference_pending = :ref_paid";
    $comando_paid_doc = $pdo->prepare($sql_paid_doc);
    $comando_paid_doc->bindParam(":paid", $amount);
    $comando_paid_doc->bindParam(':ref_paid', $referencia);
    $comando_paid_doc->execute();
    //end pending
}else{
    $factura = $t["debito"];
    $total_paid_amount = $t ["paid_amount_debit"];

    $new_total_paid_amount = $total_paid_amount + $amount;
    $saldo = $factura - $new_total_paid_amount;

    //update pending:
    $sql_paid_doc = "update sales_pending set amount_paid_pending = :paid where reference_pending = :ref_paid";
    $comando_paid_doc = $pdo->prepare($sql_paid_doc);
    $comando_paid_doc->bindParam(":paid", $new_total_paid_amount);
    $comando_paid_doc->bindParam(':ref_paid', $referencia);
    $comando_paid_doc->execute();
    //end pending  
}
    $sql_saldo_doc = "update sales_cc set saldo_doc = :saldo where reference_doc = :ref_doc";
    $comando_saldo_doc = $pdo->prepare($sql_saldo_doc);
    $comando_saldo_doc->bindParam(":saldo", $saldo);
    $comando_saldo_doc->bindParam(':ref_doc', $referencia);
    $comando_saldo_doc->execute();
}//fim


use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\PaymentDebit;
use App\Model\Shipment;
use Validator;
use DB;
use Session;
use Auth;
use PDF;
use App\Http\Start\Helpers;

class PaymentDebitController extends Controller
{
    public function __construct(Auth $auth, PaymentDebit $payment,Shipment $shipment,EmailController $email){
          $this->auth = $auth::user(); 
          $this->payment = $payment; 
          $this->shipment = $shipment;
          $this->email = $email;
    }

       /**
    * Payment list
    */
    public function index(){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'payment/list';
       $data['paymentList'] = DB::table('payment_history_debito')
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history_debito.customer_id')
                             ->leftjoin('payment_terms','payment_terms.id','=','payment_history_debito.payment_type_id')
                             ->leftjoin('sales_debito','sales_debito.reference_debit','=','payment_history_debito.invoice_reference')
                             ->select('payment_history_debito.*','debtors_master.name','payment_terms.name as pay_type','sales_debito.order_no_id as invoice_id','sales_debito.order_reference_id_debit as order_id')
                             ->orderBy('payment_history_debito.payment_date','DESC')
                             ->get();

        $data['accounts'] = DB::table('bank_accounts')->where(['deleted'=>0])->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->pluck('name','id');
        
        return view('admin.payment.paymentList', $data);     
    }

    /**
     * Create new payment.
     *
     */
    public function createPayment(Request $request)
    {
        $this->validate($request, [
            'account_no'=>'required',
            'payment_type_id' => 'required',
            'category_id'=>'required',
            'amount' => 'required|numeric',
            'payment_date'=>'required',
            'description' =>'required'
        ]);

        // Transaction Table
        //$data['debit_no_id'] = $request->debit_no_id;
        $data['account_no'] = $request->account_no;
        $data['trans_date'] = DbDateFormat($request->payment_date);
        $data['description'] = $request->description;
        $data['amount'] = abs($request->amount);
        $data['category_id'] = $request->category_id;
        //$data['reference'] = $request->reference;
        $data['person_id'] = $this->auth->id;
        $data['trans_type'] = 'cash-in-by-sale';
        $data['payment_method'] = $request->payment_type_id;
        $data['created_at'] = date("Y-m-d H:i:s");
        $transactionId = DB::table('bank_trans')->insertGetId($data);

        // Payment Table
        //$payment['debit_no_id'] = $request->debit_no_id;
        $payment['transaction_id'] = $transactionId;
        $payment['invoice_reference'] = $request->invoice_reference;
        $payment['order_reference'] = $request->order_reference;
        $payment['payment_type_id'] = $request->payment_type_id;
        $payment['amount'] =  abs($request->amount);
        $payment['payment_date'] = DbDateFormat($request->payment_date);
        $payment['reference'] =  $request->idrecibo; 
        $payment['person_id'] = $this->auth->id;
        $payment['customer_id'] = $request->customer_id; 
        
        $orderNo = $request->order_no; 
        $invoiceNo = $request->invoice_no; 
        $payment = DB::table('payment_history')->insertGetId($payment);

        //Start CC
        require './conexao.php';
        
        $doc = $_POST['invoice_reference'];
        $parte_ord_doc = $_POST["invoice_no"];
        $parte_ord = $_POST["order_reference"];
        $id = $_POST['customer_id'];
        $reference = $_POST['idrecibo'];
        $account_no = $_POST['account_no'];
        $payment_method = $_POST['payment_type_id'];
        $category_id = $_POST['category_id'];
        $ttl_paid = $_POST["amount"];
        $trans_date = $_POST['payment_date'];

        $data1 = substr($trans_date, 0, 2);
        $data2 = substr($trans_date, 3, 2);
        $data3 = substr($trans_date, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }


          $insert_rec = "insert into sales_cc (debtor_no_doc, order_no_doc, rec_no_doc, reference_doc, order_reference_doc, amount_credito_doc, payment_type_id_doc, ord_date_doc) values (:debtor_no_doc, :order_no_doc, :rec_no_doc, :reference_doc, :order_reference_doc, :amount_credito_doc, :payment_type_id_doc, :ord_date_doc)";
          $comando_update_rec = $pdo->prepare($insert_rec);
          $comando_update_rec->bindParam(":debtor_no_doc", $id);//customer
          $comando_update_rec->bindParam(":order_no_doc", $parte_ord_doc);//order_no_doc
          $comando_update_rec->bindParam(":rec_no_doc", $payment);
          $comando_update_rec->bindParam(":reference_doc", $reference);//recibo
          $comando_update_rec->bindParam(":order_reference_doc", $parte_ord);//cot
          $comando_update_rec->bindParam(":amount_credito_doc", $ttl_paid);//total pago
          $comando_update_rec->bindParam(":payment_type_id_doc", $payment_method);//new
          $comando_update_rec->bindParam(":ord_date_doc", $data_final);//data
          if($comando_update_rec->execute()){
            if (!empty($payment)) {
              $paidAmount = $this->payment->updatePayment($request->invoice_reference,$request->amount);
              \Session::flash('success',trans('message.success.save_success'));
              return redirect()->intended('invoice/view-detail-invoice-debito/'.$orderNo.'/'.$invoiceNo);
            }
          }
    }

    public function updatePayment(Request $request){
        
        $preAmount = $request->preAmount;
        $invoiceRef = $request->invoice_ref;
        
        $totalPaidAmount = DB::table('sales_debito')
                     ->where(['order_reference_debit'=>$invoiceRef])
                     ->sum('paid_amount_debit');

        $newAmount   = ($totalPaidAmount-$preAmount)+$request->amount;

       DB::table('sales_debito')
                     ->where(['order_reference_debit'=>$invoiceRef])
                     ->update(['paid_amount_debit'=>$newAmount]);


        $payment_id = $request->pid;
        $transaction_id = $request->trid;  
        $amount = $request->amount;
        $account_no = $request->account_no;
        $category_id = $request->category_id;
        $status = $request->status;
        
       DB::table('payment_history_debito')
                     ->where(['id'=>$payment_id])
                     ->update(['amount'=>$amount,'status'=>$status]);

        $trans['account_no'] = $account_no; 
        $trans['category_id'] = $category_id;
        $trans['amount'] = $amount;

       DB::table('bank_trans_debito')
                     ->where(['id'=>$transaction_id])
                     ->update($trans);

     \Session::flash('success',trans('message.extra_text.payment_success'));
     return redirect()->intended('payment/list');

     }
}
