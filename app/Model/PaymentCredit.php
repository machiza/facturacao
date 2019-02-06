<?php

namespace App\Model;
use DB;

use Illuminate\Database\Eloquent\Model;

class PaymentCredit extends Model
{
    protected $table = 'payment_history_credito';

  /**
  * Update order table with invoice payment
  * @invoice_reference
  */
  public function updatePayment($reference,$amount){

    $currentAmount = DB::table('sales_credito')->where('reference_credit',$reference)->select('paid_amount_credit')->first();
    $sum = ($currentAmount->paid_amount_credit + $amount);
    DB::table('sales_credito')->where('reference_credit',$reference)->update(['paid_amount_credit' => $sum]); 
    return true;
  }

  public function getAllPaymentByUserId($from, $to, $customer, $id){
      $from = DbDateFormat($from);
      $to = DbDateFormat($to);
     if($customer == 'all'){
     $data =  DB::table('payment_history_credito')
           ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history_credito.customer_id')
           ->leftjoin('payment_terms','payment_terms.id','=','payment_history_credito.payment_type_id')
           ->leftjoin('sales__credito','sales_credito.reference_credit','=','payment_history_credito.invoice_reference')
           ->select('payment_history_credito.*','debtors_master.name','payment_terms.name as pay_type','sales_credito.order_no_id as invoice_id','sales_credito.order_reference_id_credit as order_id')
           ->where('payment_history_credito.person_id',$id)
           ->whereDate('payment_history_credito.payment_date','>=', $from)
           ->whereDate('payment_history_credito.payment_date','<=', $to)
           ->orderBy('payment_history_credito.payment_date','DESC')
           ->get();
          }else if($customer != 'all'){
     $data =  DB::table('payment_history_credito')
           ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history_credito.customer_id')
           ->leftjoin('payment_terms','payment_terms.id','=','payment_history_credito.payment_type_id')
           ->leftjoin('sales_credito','sales_credito.reference_credit','=','payment_history_credito.invoice_reference')
           ->select('payment_history_credito.*','debtors_master.name','payment_terms.name as pay_type','sales_credito.order_no_id as invoice_id','sales_credito.order_reference_id_credit as order_id')
           ->where(['payment_history_credito.person_id'=>$id,'payment_history_credito.customer_id'=>$customer])
           ->whereDate('payment_history_credito.payment_date','>=', $from)
           ->whereDate('payment_history_credito.payment_date','<=', $to)           
           ->orderBy('payment_history_credito.payment_date','DESC')
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

        $data = DB::table('payment_history_credito')
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history_credito.customer_id')
                             ->leftjoin('payment_terms','payment_terms.id','=','payment_history_credito.payment_type_id')
                             ->leftjoin('sales_credito','sales_credito.reference_credit','=','payment_history_credito.invoice_reference')
                             ->select('payment_history_credito.*','debtors_master.name','payment_terms.name as pay_type','sales_credito.order_no_id as invoice_id','sales_credito.order_reference_id_credit as order_id')
                             ->where('payment_history_credito.payment_date','>=',$from)
                             ->where('payment_history_credito.payment_date','<=',$to)
                             ->where($conditions)
                             ->orderBy('payment_history_credito.payment_date','DESC')
                             ->get();   
        return $data; 
   }
}
