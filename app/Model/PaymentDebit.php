<?php

namespace App\Model;
use DB;

use Illuminate\Database\Eloquent\Model;

class PaymentDebit extends Model
{
   protected $table = 'payment_history_debito';

  /**
  * Update order table with invoice payment
  * @invoice_reference
  */
  public function updatePayment($reference,$amount){

    $currentAmount = DB::table('sales_debito')->where('reference_debit',$reference)->select('paid_amount_debit')->first();
    $sum = ($currentAmount->paid_amount_debit + $amount);
    DB::table('sales_debito')->where('reference_debit',$reference)->update(['paid_amount_debit' => $sum]); 
    return true;
  }

  public function getAllPaymentByUserId($from, $to, $customer, $id){
      $from = DbDateFormat($from);
      $to = DbDateFormat($to);
     if($customer == 'all'){
     $data =  DB::table('payment_history_debito')
           ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history_debito.customer_id')
           ->leftjoin('payment_terms','payment_terms.id','=','payment_history_debito.payment_type_id')
           ->leftjoin('sales__debito','sales_debito.reference_debit','=','payment_history_debito.invoice_reference')
           ->select('payment_history_debito.*','debtors_master.name','payment_terms.name as pay_type','sales_debito.order_no_id as invoice_id','sales_debito.order_reference_id_debit as order_id')
           ->where('payment_history_debito.person_id',$id)
           ->whereDate('payment_history_debito.payment_date','>=', $from)
           ->whereDate('payment_history_debito.payment_date','<=', $to)
           ->orderBy('payment_history_debito.payment_date','DESC')
           ->get();
          }else if($customer != 'all'){
     $data =  DB::table('payment_history_debito')
           ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history_debito.customer_id')
           ->leftjoin('payment_terms','payment_terms.id','=','payment_history_debito.payment_type_id')
           ->leftjoin('sales_debito','sales_debito.reference_debit','=','payment_history_debito.invoice_reference')
           ->select('payment_history_debito.*','debtors_master.name','payment_terms.name as pay_type','sales_debito.order_no_id as invoice_id','sales_debito.order_reference_id_debit as order_id')
           ->where(['payment_history_debito.person_id'=>$id,'payment_history_debito.customer_id'=>$customer])
           ->whereDate('payment_history_debito.payment_date','>=', $from)
           ->whereDate('payment_history_debito.payment_date','<=', $to)           
           ->orderBy('payment_history_debito.payment_date','DESC')
           ->get();
          }
      return $data;

  }
  /**
  * Filter the payment history
  * @$from, $to, $customer, $payment_method
  */

   public function paymentFilter($from, $to, $customer, $payment_method){
        $from = DbDateFormat($from);
        $to = DbDateFormat($to);
        $conditions = array();
        
        if($customer){
          $conditions['customer_id'] = $customer;
        }
        if($payment_method){
          $conditions['payment_type_id'] = $payment_method;
        }

        $data = DB::table('payment_history_debito')
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history_debito.customer_id')
                             ->leftjoin('payment_terms','payment_terms.id','=','payment_history_debito.payment_type_id')
                             ->leftjoin('sales_debito','sales_debito.reference_debit','=','payment_history_debito.invoice_reference')
                             ->select('payment_history_debito.*','debtors_master.name','payment_terms.name as pay_type','sales_debito.order_no_id as invoice_id','sales_debito.order_reference_id_debit as order_id')
                             ->where('payment_history_debito.payment_date','>=',$from)
                             ->where('payment_history_debito.payment_date','<=',$to)
                             ->where($conditions)
                             ->orderBy('payment_history_debito.payment_date','DESC')
                             ->get();   
        return $data; 
   }
}
