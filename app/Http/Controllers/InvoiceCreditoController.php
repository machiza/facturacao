<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Creditos;
use App\Model\Orders;
use App\Model\Sales; 
use App\Model\Shipment;
use App\Model\Deposit;
use App\Http\Start\Helpers;
use DB;
use PDF;
use Session;

class InvoiceCreditoController extends Controller
{
        public function __construct(Orders $orders, Creditos $creditos, Sales $sales, Shipment $shipment,EmailController $email, Deposit $deposit){

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

    public function viewInvoiceDetailsCredito($id){
        //$orderNo,$invoiceNo,
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_credito';
        $data['SaleCredito'] =DB::table('sales_credito')->where('credit_no',$id)
                                          ->select("sales_credito.*")
                                          ->first();
        $order_number=$data['SaleCredito']->order_no_id; 
        $customerID=$data['SaleCredito']->debtor_no_credit; 
       

       $data['saleDataOrder'] = DB::table('sales_orders')
                            ->where('order_no', '=', $order_number)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')

                            ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')

                            ->select("sales_orders.*", "sales_credito.*","location.location_name")
                            ->first();
        if($data['saleDataOrder']==null){
            //return 'data is null';

      

          $data['saleDataInvoice'] = DB::table('sales_credito')
            ->where('sales_credito.credit_no', '=', $id)
            ->leftJoin('location','location.loc_code','=','sales_credito.from_stk_loc')
            ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_credito.payment_term_credit')
           // ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')
            ->select("sales_credito.*", "location.location_name",'invoice_payment_terms.days_before_due')
            ->first();  
        $data['invoiceData'] = $this->order->getCreditOrderByID($id,$data['saleDataInvoice']->from_stk_loc);             
        }

        else{
             $data['invoiceType'] = $data['saleDataOrder']->invoice_type;
             $cotacao=$data['cotacao'] = $data['saleDataOrder']->order_reference_id  ;
             $data['factura'] = $data['saleDataOrder']->reference;
                  $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $cotacao)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')
                    ->select("sales_orders.*",  "sales_credito.*", "location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();                    
        $data['invoiceData'] = $this->order->getSalseOrderByID($cotacao,$data['saleDataInvoice']->from_stk_loc);
       }
        $data['customerInfo']  = DB::table('debtors_master')
                             ->where('debtors_master.debtor_no',$customerID)
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','debtors_master.debtor_no')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id','cust_branch.nuit')                            
                             ->first();                       
        //d($data['customerInfo'],1);

       $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$order_number)->select('reference','order_no')->first();

        $data['payments']   = DB::table('payment_terms')->get();
        
        if ($order_number!="") {
        $data['paymentsList'] = DB::table('payment_history')
                                ->where(['order_reference'=>$data['orderInfo']->reference])
                                ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                                ->select('payment_history.*','payment_terms.name')
                                ->orderBy('payment_date','DESC')
                                ->get();
       

        $data['invoice_no'] = $order_number;
        
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
         }
         //contador recibos:
        $credit_count = DB::table('sales_credito')->count();
        if($credit_count>0){
                
            if ($order_number!=0) {
                 $invoiceReference = DB::table('payment_history')->select('reference')->orderBy('id','DESC')->first();

                 $referencia= $data['saleDataOrder']->reference;

                $ref = explode("-",$referencia);
                $data['credit_count'] = (int) $ref[1];
                //$invoiceReference->reference
            }
           
        }else{
            $data['credit_count'] = 0 ;
        }
  

      
        $data['produtos']= DB::table('sales_credito')
                                            ->leftjoin('sales_order_details','sales_credito.credit_no','=','sales_order_details.order_no')
                                            ->leftJoin('item_tax_types', 'item_tax_types.id','=','sales_order_details.tax_type_id')
                                            ->select('sales_order_details.stock_id','sales_order_details.description','sales_order_details.unit_price','sales_order_details.quantity','sales_order_details.discount_percent','sales_order_details.tax_type_id','item_tax_types.tax_rate')->where('credit_no',$id)->where('tipo_operacao','=','credito')
                                             ->orderBy('sales_order_details.id','ASC')
                                            ->get();

        $data['empresa']=DB::table('preference')->where('id',20)->first();

                                          

        return view('admin.invoice.viewInvoiceDetailsCredito', $data);
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
    
    /**
    * Invoice print
    */
public function invoicePrint($id){

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_credito';
        $data['SaleCredito'] =DB::table('sales_credito')->where('credit_no',$id)
                                          ->select("sales_credito.*")
                                          ->first();
        $order_number=$data['SaleCredito']->order_no_id; 
        $customerID=$data['SaleCredito']->debtor_no_credit; 
       

       $data['saleDataOrder'] = DB::table('sales_orders')
                            ->where('order_no', '=', $order_number)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')

                            ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')

                            ->select("sales_orders.*", "sales_credito.*","location.location_name")
                            ->first();
        if($data['saleDataOrder']==null){
            //return 'data is null';

      

                  $data['saleDataInvoice'] = DB::table('sales_credito')
                    ->where('sales_credito.credit_no', '=', $id)
                    ->leftJoin('location','location.loc_code','=','sales_credito.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_credito.payment_term_credit')
                   // ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')
                    ->select("sales_credito.*", "location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();  
                $data['invoiceData'] = $this->order->getCreditOrderByID($id,$data['saleDataInvoice']->from_stk_loc);             
        }

        else{
             $data['invoiceType'] = $data['saleDataOrder']->invoice_type;
             $cotacao=$data['cotacao'] = $data['saleDataOrder']->order_reference_id  ;
             $data['factura'] = $data['saleDataOrder']->reference;
                  $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $cotacao)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')
                    ->select("sales_orders.*",  "sales_credito.*", "location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();                    
        $data['invoiceData'] = $this->order->getSalseOrderByID($cotacao,$data['saleDataInvoice']->from_stk_loc);
       }
        $data['customerInfo']  = DB::table('debtors_master')
                             ->where('debtors_master.debtor_no',$customerID)
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','debtors_master.debtor_no')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id','cust_branch.nuit')                            
                             ->first();                       
        //d($data['customerInfo'],1);

       $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$order_number)->select('reference','order_no')->first();

        $data['payments']   = DB::table('payment_terms')->get();
        
        if ($order_number!="") {
        $data['paymentsList'] = DB::table('payment_history')
                                ->where(['order_reference'=>$data['orderInfo']->reference])
                                ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                                ->select('payment_history.*','payment_terms.name')
                                ->orderBy('payment_date','DESC')
                                ->get();
       

        $data['invoice_no'] = $order_number;
        
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
         }
         //contador recibos:
        $credit_count = DB::table('sales_credito')->count();
        if($credit_count>0){
                
            if ($order_number!=0) {
                 $invoiceReference = DB::table('payment_history')->select('reference')->orderBy('id','DESC')->first();

                 $referencia= $data['saleDataOrder']->reference;

                $ref = explode("-",$referencia);
                $data['credit_count'] = (int) $ref[1];
                //$invoiceReference->reference
            }
           
        }else{
            $data['credit_count'] = 0 ;
        }

      
        $data['produtos']= DB::table('sales_credito')
                                            ->leftjoin('sales_order_details','sales_credito.credit_no','=','sales_order_details.order_no')
                                            ->leftJoin('item_tax_types', 'item_tax_types.id','=','sales_order_details.tax_type_id')
                                            ->select('sales_order_details.stock_id','sales_order_details.description','sales_order_details.unit_price','sales_order_details.quantity','sales_order_details.discount_percent','sales_order_details.tax_type_id','item_tax_types.tax_rate')->where('credit_no',$id)->where('tipo_operacao','=','credito')
                                             ->orderBy('sales_order_details.id','ASC')
                                            ->get();

        $data['empresa']=DB::table('preference')->where('id',20)->first();

        $pdf = PDF::loadView('admin.invoice.invoiceCreditoPrint', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('credit_'.time().'.pdf',array("Attachment"=>0));        
    }

    /**
    * Generate pdf for invoice
    */
    public function invoicePdf($id){

       $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_credito';
        $data['SaleCredito'] =DB::table('sales_credito')->where('credit_no',$id)
                                          ->select("sales_credito.*")
                                          ->first();
        $order_number=$data['SaleCredito']->order_no_id; 
        $customerID=$data['SaleCredito']->debtor_no_credit; 
       

       $data['saleDataOrder'] = DB::table('sales_orders')
                            ->where('order_no', '=', $order_number)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')

                            ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')

                            ->select("sales_orders.*", "sales_credito.*","location.location_name")
                            ->first();
        if($data['saleDataOrder']==null){
            //return 'data is null';

      

                  $data['saleDataInvoice'] = DB::table('sales_credito')
                    ->where('sales_credito.credit_no', '=', $id)
                    ->leftJoin('location','location.loc_code','=','sales_credito.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_credito.payment_term_credit')
                   // ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')
                    ->select("sales_credito.*", "location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();  
                $data['invoiceData'] = $this->order->getCreditOrderByID($id,$data['saleDataInvoice']->from_stk_loc);             
        }

        else{
             $data['invoiceType'] = $data['saleDataOrder']->invoice_type;
             $cotacao=$data['cotacao'] = $data['saleDataOrder']->order_reference_id  ;
             $data['factura'] = $data['saleDataOrder']->reference;
                  $data['saleDataInvoice'] = DB::table('sales_orders')
                    ->where('order_no', '=', $cotacao)
                    ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                    ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_orders.payment_term')
                    ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')
                    ->select("sales_orders.*",  "sales_credito.*", "location.location_name",'invoice_payment_terms.days_before_due')
                    ->first();                    
        $data['invoiceData'] = $this->order->getSalseOrderByID($cotacao,$data['saleDataInvoice']->from_stk_loc);
       }
        $data['customerInfo']  = DB::table('debtors_master')
                             ->where('debtors_master.debtor_no',$customerID)
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','debtors_master.debtor_no')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id','cust_branch.nuit')                            
                             ->first();                       
        //d($data['customerInfo'],1);

       $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$order_number)->select('reference','order_no')->first();

        $data['payments']   = DB::table('payment_terms')->get();
        
        if ($order_number!="") {
        $data['paymentsList'] = DB::table('payment_history')
                                ->where(['order_reference'=>$data['orderInfo']->reference])
                                ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                                ->select('payment_history.*','payment_terms.name')
                                ->orderBy('payment_date','DESC')
                                ->get();
       

        $data['invoice_no'] = $order_number;
        
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
         }
         //contador recibos:
        $credit_count = DB::table('sales_credito')->count();
        if($credit_count>0){
                
            if ($order_number!=0) {
                 $invoiceReference = DB::table('payment_history')->select('reference')->orderBy('id','DESC')->first();

                 $referencia= $data['saleDataOrder']->reference;

                $ref = explode("-",$referencia);
                $data['credit_count'] = (int) $ref[1];
                //$invoiceReference->reference
            }
           
        }else{
            $data['credit_count'] = 0 ;
        }

      
        $data['produtos']= DB::table('sales_credito')
                                            ->leftjoin('sales_order_details','sales_credito.credit_no','=','sales_order_details.order_no')
                                            ->leftJoin('item_tax_types', 'item_tax_types.id','=','sales_order_details.tax_type_id')
                                            ->select('sales_order_details.stock_id','sales_order_details.description','sales_order_details.unit_price','sales_order_details.quantity','sales_order_details.discount_percent','sales_order_details.tax_type_id','item_tax_types.tax_rate')->where('credit_no',$id)->where('tipo_operacao','=','credito')
                                             ->orderBy('sales_order_details.id','ASC')
                                            ->get();

        $data['empresa']=DB::table('preference')->where('id',20)->first();

        
        //$pdf = PDF::loadView('admin.invoice.invoiceCreditoPdf', $data);
        $pdf = PDF::loadView('admin.invoice.invoiceCreditoPrint', $data);
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
