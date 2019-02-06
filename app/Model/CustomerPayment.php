<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
	
  public function invoiceInformation($orderno,$invoiceno){
    $data = DB::table('sales_orders')
          ->where(['sales_orders.order_no'=>$invoiceno,'sales_orders.order_reference_id'=>$orderno])
          ->leftjoin('debtors_master','debtors_master.debtor_no', '=', 'sales_orders.debtor_no')
          ->select('sales_orders.total','sales_orders.paid_amount','debtors_master.name','debtors_master.email')
          ->first();
    return $data;
  }

    /**
  * Update order table with invoice payment
  * @invoice_reference
  */
  public function updatePayment($reference,$amount){

    $currentAmount = DB::table('sales_orders')->where('reference',$reference)->select('paid_amount')->first();
    $sum = ($currentAmount->paid_amount + $amount);
    DB::table('sales_orders')->where('reference',$reference)->update(['paid_amount' => $sum]); 
    return true;
  }

}
