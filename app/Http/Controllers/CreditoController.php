<?php

namespace App\Http\Controllers;

use App\Model\Creditos;
use App\Model\Credito;
use App\Model\SaleCC;
use App\Model\SockMove;
use App\Model\SalePending;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use PDF;
use App\Http\Start\Helpers;

class CreditoController extends Controller
{
    public function __construct(Creditos $credito){
     /**
     * Set the database connection. reference app\helper.php
     */   
        //selectDatabase();
        $this->sale = $credito;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_credito';

        $data['cotacoes'] = DB::table('sales_credito')
        ->leftjoin('sales_orders','sales_credito.order_no_id','=','sales_orders.order_no')
        ->leftjoin('debtors_master','sales_credito.debtor_no_credit','=','debtors_master.debtor_no')
        ->select("sales_orders.*", "sales_credito.*","debtors_master.*")->orderBy('credit_no', 'desc')
        ->get();

        $data['Total_por_pagar'] = DB::table('sales_credito')->sum('credito');   
        $data['pago'] = DB::table('sales_credito')->sum('paid_amount_credit');   
        $data['saldo'] = $data['Total_por_pagar']-$data['pago'];

        // Novo 
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : NULL;
        $data['customerList'] = DB::table('debtors_master')->select('debtor_no','name')->where(['inactive'=>0])->get();

        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESINVOICE)->orderBy('ord_date','asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? formatDate(date("d-m-Y", strtotime($fromDate->ord_date))) : formatDate(date('d-m-Y')); 
        $data['to'] = $to = formatDate(date('d-m-Y')); 
        // End Novo

        return view('admin.sale.sales_credito', $data);
    }






    public function getInvoices(){
        require './conexao.php';
        $sql = "Select * from sales_orders where invoice_type = 'directInvoice' and debtor_no = '" . $_POST["debtor_no"] . "'";
        $comando = $pdo->prepare($sql);
        $comando->execute();
        $row = $comando->rowCount();
        if($row >= 1){
            echo "<option value=''>". trans('message.form.select_ones') ."</option>";
            while ($rs = $comando->fetch()){
                    $id = $rs ["order_no"];
                    $ref = $rs ["reference"];
                    echo "<option value='$id'>$ref</option>";
            }
        }else{
            echo "<option value=''>". trans('message.form.no_invoice') ."</option>";
        }
    }

    public function create(){


    	$data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_credito';
        //$data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->get();
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();

        $data['salesData'] = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->get();

        $data['locData'] = DB::table('location')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        //d($data['payments'],1);
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();
        $invoice_count = DB::table('sales_credito')->count();
        
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get();        
        
        if($invoice_count>0){
        $invoiceReference = DB::table('sales_credito')->select('reference_credit')->orderBy('credit_no','DESC')->first();

       $ref = explode("-",$invoiceReference->reference_credit);
        $data['invoice_count'] = (int) $ref[1];
        }else{
            $data['invoice_count'] = 0 ;
        }
        
        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
     
        $selectStart = "<select class='form-control taxList taxa' name='tax_id[]'>";
        $selectEnd = "</select>";
        
        $selectStartCustom = "<select class='form-control taxListCustom taxa' name='tax_id[]'>";
        $selectEndCustom = "</select>";

        
        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";          
        }
        $data['tax_type'] = $selectStart.$taxOptions.$selectEnd;
        $data['tax_type_custom'] = $selectStartCustom.$taxOptions.$selectEndCustom;
        
        $dt = date("Y/m/d");
        $data['parte_ano']= substr($dt,  0, 4);

    	return view('admin.sale.credit_add', $data);
    }

   



     /**
     * Store a newly created resource in storage.
     **/

        public function edit($id){

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_credito';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);


        //$data['DebitoData'] = DB::table('sales_debito')->where('debit_no','=',$id)->first();  
         $data['CreditoData'] = DB::table('sales_credito')
            ->where('sales_credito.credit_no', '=', $id)
            ->leftJoin('location','location.loc_code','=','sales_credito.from_stk_loc')
            ->leftJoin('invoice_payment_terms','invoice_payment_terms.id','=','sales_credito.payment_term_credit')
           // ->leftjoin('sales_credito','sales_credito.order_no_id','=','sales_orders.order_no')
            ->select("sales_credito.*", "location.location_name",'invoice_payment_terms.days_before_due')
            ->first();  

       //debtor_no_debit      


       // {"credit_no":5,"credito":380250,"order_no_id":0,"credit_date":"2019-01-23","trans_type_credit":201,"debtor_no_credit":2,"person_id_credit":2,"reference_credit":"NC-0005\/2019","order_reference_id_credit":0,"order_reference_credit":null,"invoice_type_credit":"directInvoice","from_stk_loc":"PL","payment_id_credit":2,"paid_amount_credit":0,"payment_term_credit":1,"comments":null,"created_at":null,"updated_at":null,"location_name":"Armazem I","days_before_due":0}]    


        $data['CreditoDetalhes'] = $this->sale->getSalseData($id);  

        $novo = array();
        $elemento="";

        foreach ($data['CreditoDetalhes']  as $info) {
           if($info->item_id!=null){
                array_push($novo,$info->item_id);
                $elemento=$info->item_id.'/'.$elemento;
            }
        }
        $data['elementos'] =$elemento;


        $data['salesData'] = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->get();
        $data['locData'] = DB::table('location')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();
        $invoice_count = DB::table('sales_debito')->count();
        
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get();        
        
        if($invoice_count>0){
        $invoiceReference = DB::table('sales_debito')->select('reference_debit')->orderBy('debit_no','DESC')->first();

         $ref = explode("-",$invoiceReference->reference_debit);
        $data['invoice_count'] = (int) $ref[1];
        }else{
            $data['invoice_count'] = 0 ;
        }
        
        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
     
        $selectStart = "<select class='form-control taxList taxa' name='tax_id[]'>";
        $selectEnd = "</select>";
        
        $selectStartCustom = "<select class='form-control taxListCustom taxa' name='tax_id[]'>";
        $selectEndCustom = "</select>";

        
        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";          
        }
        $data['tax_type'] = $selectStart.$taxOptions.$selectEnd;
        $data['tax_type_custom'] = $selectStartCustom.$taxOptions.$selectEndCustom;
        $data['tax_type_new'] = $selectStart.$taxOptions.$selectEnd;
        $data['tax_types'] = $taxTypeList;


        return view('admin.sale.credit_edit', $data);


    }
   
 


    //funcao edited by sh@dy
    public function store(Request $request)
     {
           $userId = \Auth::user()->id;
            $itemQuantity = $request->item_quantity;        
            $itemIds = $request->item_id;
            $itemDiscount = $request->discount;
            $taxIds = $request->tax_id;
            $unitPrice = $request->unit_price;
            $stock_id = $request->stock_id;
            $description = $request->description;
            $taxTotal=0;    

            $ord_date = $request->ord_date;

            $data_final="";
            $data1 = substr($ord_date, 0, 2);
            $data2 = substr($ord_date, 3, 2);
            $data3 = substr($ord_date, 6, 4);
            if($data1 > 10){
               $data_final = $data3."-". + $data2."-". + $data1; 
            }else{
               $data_final = $data3."-". + $data2."-0". + $data1;
            }

            $invoice_type_credit = 'directInvoice';
            $trans_type_credit_indirect = 201;


            $NovaOrdem['credito'] = $request->total;
            if($request->reference_order_fact!=""){
                $NovaOrdem['order_no_id'] = $request->reference_order_fact;
            }
            $NovaOrdem['credit_date'] =  $data_final;
            $NovaOrdem['trans_type_credit'] =$trans_type_credit_indirect;
            $NovaOrdem['debtor_no_credit'] = $request->debtor_no;
            $NovaOrdem['person_id_credit'] = $userId;
            $NovaOrdem['reference_credit'] = $request->reference_credit;
            $NovaOrdem['invoice_type_credit'] = $invoice_type_credit;
            $NovaOrdem['from_stk_loc'] = $request->from_stk_loc;;            
            $NovaOrdem['payment_id_credit'] = $request->payment_id;         
            $NovaOrdem['payment_term_credit'] =$request->payment_term;           
            $NrNotaCredito= DB::table('sales_credito')->insertGetId($NovaOrdem);


            //$saida = "1";
             $saida = "0";

             $TabelaCC['debtor_no_doc'] = $request->debtor_no;
             if($request->reference_order_fact!=""){
             $TabelaCC['order_no_doc'] =$NovaOrdem['order_no_id'];
             }         
             $TabelaCC['credit_no_doc'] =$NrNotaCredito;
             $TabelaCC['reference_doc'] = $NovaOrdem['reference_credit'];
             $TabelaCC['saldo_doc'] = $request->total;
             $TabelaCC['amount_doc'] = $request->total;
             $TabelaCC['debito_credito'] = $saida;
             $TabelaCC['ord_date_doc'] = $data_final;
             $TabelaCC['amount_credito_doc'] = $request->total;
             DB::table('sales_cc')->insertGetId($TabelaCC);


            $NovoSalePeding['debtor_no_pending'] = $request->debtor_no;   
            if($request->reference_order_fact!=""){
              $NovoSalePeding['order_no_pending'] =$NovaOrdem['order_no_id'];
            }
            $NovoSalePeding['reference_pending'] =$NovaOrdem['reference_credit'];
            $NovoSalePeding['amount_total_pending'] =$request->total;
            $NovoSalePeding['ord_date_pending'] =$data_final;
            DB::table('sales_pending')->insertGetId($NovoSalePeding); 


                // Inventory Items Start
                if(!empty($description)){
                    foreach ($description as $key => $item) {
                    // create salesOrderDetail Start order_reference_id
                    $salesOrderDetail['order_no'] = $NrNotaCredito;
                    $salesOrderDetail['stock_id'] = $stock_id[$key];
                    $salesOrderDetail['description'] = $item;
                    $salesOrderDetail['quantity'] = $itemQuantity[$key];
                    $salesOrderDetail['trans_type'] = SALESORDER;
                    $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
                    $salesOrderDetail['tax_type_id'] = $taxIds[$key];
                    $salesOrderDetail['unit_price'] = $unitPrice[$key];
                   // $salesOrderDetail['is_inventory'] = 1;
                    $salesOrderDetail['tipo_operacao'] = 'credito';

                     if($stock_id[$key]=="zero"){
                        $salesOrderDetail['is_inventory'] = 0;
                    }
                    else{
                         $salesOrderDetail['is_inventory'] = 1;
                    }


                   $priceAmount = ($itemQuantity[$key]*$unitPrice[$key]);
                   $discount = ($priceAmount*$itemDiscount[$key])/100;
                   $taxass = DB::table('item_tax_types')->where('id','=',$taxIds[$key])->first()->tax_rate;    
                    $newPrice = ($priceAmount-$discount);
                    $taxAmount = (($newPrice*$taxass)/100);
                    $taxTotal += $taxAmount;     




                    DB::table('sales_order_details')->insertGetId($salesOrderDetail);
                    
                    // create stockMove
                    if($stock_id[$key]==0){
                        $stockMove['order_no'] = $NrNotaCredito;
                        $data['tran_date'] = date("Y-m-d H:i:s"); 
                        $stockMove['stock_id'] = $stock_id[$key];
                        $stockMove['loc_code'] = $request->from_stk_loc;
                        $stockMove['person_id'] = $userId;
                        $stockMove['reference'] = 'store_in_'.$NovaOrdem['reference_credit'];
                        $stockMove['qty'] =$itemQuantity[$key];
                        $stockMove['trans_type'] = SALESINVOICE;
                        DB::table('stock_moves')->insertGetId($stockMove); 

                    }
                }
         }       


            $Old['tax_total'] =$taxTotal;  
            DB::table('sales_credito')->where('credit_no','=',$NrNotaCredito)->update($Old);  

            // Create salesOrder Invoice end
            \Session::flash('success',trans('message.success.save_success'));
            //return redirect()->intended('invoice/view-detail-invoice-credito/'.$referenc.'/'.$reference);
            return redirect()->intended('invoice/view-detail-invoice-credito/'.$NrNotaCredito);
    }       


    //funcao edited by sh@dy
    public function update(Request $request)
     {
            $NrNotaCredito=$request->credito;
           
            $userId = \Auth::user()->id;
            $itemQuantity = $request->item_quantity;        
            $itemIds = $request->item_id;
            $itemDiscount = $request->discount;
            $taxIds = $request->tax_id;
            $unitPrice = $request->unit_price;
            $stock_id = $request->stock_id;
            $description = $request->description;

            $ord_date = $request->ord_date;

            $data_final="";
            $data1 = substr($ord_date, 0, 2);
            $data2 = substr($ord_date, 3, 2);
            $data3 = substr($ord_date, 6, 4);
            if($data1 > 10){
               $data_final = $data3."-". + $data2."-". + $data1; 
            }else{
               $data_final = $data3."-". + $data2."-0". + $data1;
            }

            $invoice_type_credit = 'directInvoice';
            $trans_type_credit_indirect = 201;

            $NovaOrdem['credito'] = $request->total;
            if($request->reference_order_fact!=""){
                $NovaOrdem['order_no_id'] = $request->reference_order_fact;
            }
            $NovaOrdem['credit_date'] =  $data_final;
            $NovaOrdem['trans_type_credit'] =$trans_type_credit_indirect;
            $NovaOrdem['debtor_no_credit'] = $request->debtor_no;
            $NovaOrdem['person_id_credit'] = $userId;
            $NovaOrdem['reference_credit'] = $request->reference_credit;
            $NovaOrdem['invoice_type_credit'] = $invoice_type_credit;
            $NovaOrdem['from_stk_loc'] = $request->from_stk_loc;;            
            $NovaOrdem['payment_id_credit'] = $request->payment_id;         
            $NovaOrdem['payment_term_credit'] =$request->payment_term;           
            DB::table('sales_credito')->where('credito','=',$NrNotaCredito)->update($NovaOrdem);

            //$saida = "1";
             $saida = "0";
             $TabelaCC['debtor_no_doc'] = $request->debtor_no;
             if($request->reference_order_fact!=""){
             $TabelaCC['order_no_doc'] =$NovaOrdem['order_no_id'];
             }         
             $TabelaCC['credit_no_doc'] =$NrNotaCredito;
             $TabelaCC['reference_doc'] = $NovaOrdem['reference_credit'];
             $TabelaCC['saldo_doc'] = $request->total;
             $TabelaCC['amount_doc'] = $request->total;
             $TabelaCC['debito_credito'] = $saida;
             $TabelaCC['ord_date_doc'] = $data_final;
             $TabelaCC['amount_credito_doc'] = $request->total;
             DB::table('sales_cc')->where('reference_doc','=',$NovaOrdem['reference_credit'])->update($TabelaCC);

             $NovoSalePeding['debtor_no_pending'] = $request->debtor_no;   
            if($request->reference_order_fact!=""){
              $NovoSalePeding['order_no_pending'] =$NovaOrdem['order_no_id'];
            }
            $NovoSalePeding['reference_pending'] =$NovaOrdem['reference_credit'];
            $NovoSalePeding['amount_total_pending'] =$request->total;
            $NovoSalePeding['ord_date_pending'] =$data_final;
            DB::table('sales_pending')->where('reference_pending','=',$NovaOrdem['reference_credit'])->update($NovoSalePeding);

          
            DB::table('sales_order_details')->where([['order_no','=',$NrNotaCredito],['tipo_operacao','=','credito']])->delete();

                if(!empty($description)){
                    foreach ($description as $key => $item) {
                    $salesOrderDetail['order_no'] = $NrNotaCredito;
                    $salesOrderDetail['stock_id'] = $stock_id[$key];
                    $salesOrderDetail['description'] = $item;
                    $salesOrderDetail['quantity'] = $itemQuantity[$key];
                    $salesOrderDetail['trans_type'] = SALESORDER;
                    $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
                    $salesOrderDetail['tax_type_id'] = $taxIds[$key];
                    $salesOrderDetail['unit_price'] = $unitPrice[$key];
                    $salesOrderDetail['tipo_operacao'] = 'credito';

                     if($stock_id[$key]=="zero"){
                        $salesOrderDetail['is_inventory'] = 0;
                    }
                    else{
                         $salesOrderDetail['is_inventory'] = 1;
                    }
                    DB::table('sales_order_details')->insertGetId($salesOrderDetail);
                    

                    DB::table('stock_moves')->where([['order_no','=',$NrNotaCredito],['reference','=','store_in_'.$NovaOrdem['reference_credit']]])->delete();

                    if($stock_id[$key]==0){
                        $stockMove['order_no'] = $NrNotaCredito;
                        $data['tran_date'] = date("Y-m-d H:i:s"); 
                        $stockMove['stock_id'] = $stock_id[$key];
                        $stockMove['loc_code'] = $request->from_stk_loc;
                        $stockMove['person_id'] = $userId;
                        $stockMove['reference'] = 'store_in_'.$NovaOrdem['reference_credit'];
                        $stockMove['qty'] =$itemQuantity[$key];
                        $stockMove['trans_type'] = SALESINVOICE;
                        DB::table('stock_moves')->insertGetId($stockMove); 

                    }
                }
         }       

            // Create salesOrder Invoice end
            \Session::flash('success',trans('message.success.save_success'));
            //return redirect()->intended('invoice/view-detail-invoice-credito/'.$referenc.'/'.$reference);
            return redirect()->intended('invoice/view-detail-invoice-credito/'.$NrNotaCredito);
    }       




 
    public function store1(Request $request)
    {
        //return $request->all();
        $userId = \Auth::user()->id;
        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $stock_id = $request->stock_id;
        $description = $request->description;

        require_once './conexao.php';

        $reference = $_POST["reference_order_fact"];

        $sql_credito = "Select * from sales_credito
                inner join sales_orders on sales_credito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no where order_no='$reference'";
        $comando_credito = $pdo->prepare($sql_credito);
        if($comando_credito->execute()){
            $rs_comando_credito = $comando_credito->fetch();
            if($comando_credito->rowCount() == 0){
                $trans_type_credit = 202;
            }else{
                $trans_type_credit = $rs_comando_credito ["trans_type"];
            }           

           $reference_credit = $_POST["reference_credit"];
            
            $debtor_no = $_POST["debtor_no"];
            $ord_date = $_POST["ord_date"];
            $total_tax = ($_POST["total"] * 5)/100;
            $total = $_POST["total"];

            $payment_id = $_POST["payment_id"];
            $payment_term = $_POST["payment_term"];

            $from_stk_loc = $_POST["from_stk_loc"];

            $comments =  $_POST["comments"];

            $data1 = substr($ord_date, 0, 2);
            $data2 = substr($ord_date, 3, 2);
            $data3 = substr($ord_date, 6, 4);
            if($data1 > 10){
               $data_final = $data3."-". + $data2."-". + $data1; 
            }else{
               $data_final = $data3."-". + $data2."-0". + $data1;
            }

            
            $invoice_type_credit = 'indirectOrder';
            $trans_type_credit_indirect = 201;

            // create salesOrder start
            $insert_indirect = "insert into sales_credito
                      (credito, order_no_id, credit_date, trans_type_credit, debtor_no_credit, person_id_credit, invoice_type_credit, from_stk_loc, payment_id_credit)
                      values
                      (:credito, :order_fact, :data, :trans_type_credit, :debtor_no, :person_id, :invoice_type_credit, :from_stk_loc, :payment_id)";

            $referenc = $reference - 1;

            $comando_insert_indirect = $pdo->prepare($insert_indirect);
            $comando_insert_indirect->bindParam(":credito", $total);
            $comando_insert_indirect->bindParam(":order_fact", $referenc);
            $comando_insert_indirect->bindParam(":data", $data_final);
            $comando_insert_indirect->bindParam(":trans_type_credit", $trans_type_credit_indirect);
            $comando_insert_indirect->bindParam(":debtor_no", $debtor_no);
            $comando_insert_indirect->bindParam(":person_id", $userId);
            $comando_insert_indirect->bindParam(":invoice_type_credit", $invoice_type_credit);
            $comando_insert_indirect->bindParam(":from_stk_loc", $from_stk_loc);
            $comando_insert_indirect->bindParam(":payment_id", $payment_id);
            if($comando_insert_indirect->execute()){
  
                //gmb: pega uma ordem (cot) indirect nos creditos:
                $sql_credito_lastGamb = "Select * from sales_credito
                inner join sales_orders on sales_credito.order_no_id=sales_orders.order_no
                inner join debtors_master on debtors_master.debtor_no=sales_orders.debtor_no
                where invoice_type_credit = 'indirectOrder'";
                $comando_credito_lastGamb = $pdo->prepare($sql_credito_lastGamb);
                if($comando_credito_lastGamb->execute()){
                    $rs_comando_credito_lastGamb = $comando_credito_lastGamb->fetch();
                    $order_reference_Gamb = $rs_comando_credito_lastGamb ["reference"];

                    $sql_credito_last = "Select * from sales_credito order by credit_no DESC LIMIT 1";
                    $comando_credito_last = $pdo->prepare($sql_credito_last);
                    if($comando_credito_last->execute()){
                         $rs_comando_credito_last = $comando_credito_last->fetch();
                       //order_reference_id:
                       $order_reference_id = $rs_comando_credito_last ["credit_no"];
                       // create salesOrder end

                        // Create salesOrder Invoice start
                        $invoice_type_credit_direct = 'directInvoice';
                        $insert = "insert into sales_credito (credito, order_no_id, credit_date, trans_type_credit, debtor_no_credit, person_id_credit, reference_credit, order_reference_id_credit, order_reference_credit, invoice_type_credit, from_stk_loc, payment_id_credit, payment_term_credit, comments) values (:credito, :order_fact, :data, :trans_type_credit, :debtor_no, :person_id, :reference_credit, :order_reference_id, :order_reference_credit, :invoice_type_credit, :from_stk_loc, :payment_id, :payment_term,  :comments)";
                        $comando_insert = $pdo->prepare($insert);
                        $comando_insert->bindParam(":credito", $total);
                        $comando_insert->bindParam(":order_fact", $reference);
                        $comando_insert->bindParam(":data", $data_final);
                        $comando_insert->bindParam(":trans_type_credit", $trans_type_credit);
                        $comando_insert->bindParam(":debtor_no", $debtor_no);
                        $comando_insert->bindParam(":person_id", $userId);
                        $comando_insert->bindParam(":reference_credit", $reference_credit);
                        $comando_insert->bindParam(":order_reference_id", $order_reference_id);//id cot indirect
                        $comando_insert->bindParam(":order_reference_credit", $order_reference_Gamb);//ref cot indirecta
                        $comando_insert->bindParam(":invoice_type_credit", $invoice_type_credit_direct);
                        $comando_insert->bindParam(":from_stk_loc", $from_stk_loc);
                        $comando_insert->bindParam(":payment_id", $payment_id);
                        $comando_insert->bindParam(":payment_term", $payment_term);
                       // $comando_insert->bindParam(":saldo_credit", $total);
                        $comando_insert->bindParam(":comments", $comments);
                        if($comando_insert->execute()){
                            $sql_credito_last2 = "Select * from sales_credito order by credit_no DESC LIMIT 1";
                            $comando_credito_last2 = $pdo->prepare($sql_credito_last2);
                            if($comando_credito_last2->execute()){
                                $rs_comando_credito_last2 = $comando_credito_last2->fetch();
                                //order_reference_id:
                                $order_reference_id2 = $rs_comando_credito_last2 ["credit_no"];


                                   //cc
                            $sql_last_credit = "Select * from sales_credito order by credit_no DESC LIMIT 1";
                            $comando_last_credit = $pdo->prepare($sql_last_credit);
                            if($comando_last_credit->execute()){
                                $id_cred = $comando_last_credit->fetch();
                                $ord_cred = $id_cred["order_no_id"];
                                $ref_cred = $id_cred["reference_credit"];
                                $order_ref_fact = $id_cred["order_reference_credit"];
                                $insert_doc = "insert into sales_cc (debtor_no_doc, order_no_doc, credit_no_doc, reference_doc, order_reference_doc, amount_credito_doc, saldo_doc, debito_credito, ord_date_doc) values (:debtor_no_doc, :order_no_doc, :credit_no_doc, :reference_doc, :order_reference_doc, :amount_credito_doc, :saldo_doc, :debito_credito, :ord_date_doc)";
                                $saida = "1";
                                $comando_update_cred = $pdo->prepare($insert_doc);
                                $comando_update_cred->bindParam(":debtor_no_doc", $debtor_no);
                                $comando_update_cred->bindParam(":order_no_doc", $ord_cred);
                                $comando_update_cred->bindParam(":credit_no_doc", $id_cred["credit_no"]);
                                $comando_update_cred->bindParam(":reference_doc", $ref_cred);
                                $comando_update_cred->bindParam(":order_reference_doc", $order_ref_fact);
                                $comando_update_cred->bindParam(":amount_credito_doc", $total);
                                $comando_update_cred->bindParam(":saldo_doc", $total);
                                $comando_update_cred->bindParam(":debito_credito", $saida);
                                $comando_update_cred->bindParam(":ord_date_doc", $data_final);
                                $comando_update_cred->execute();
                            }
                            //end cc

                            //pending
                            $sql_last = "Select * from sales_credito order by credit_no DESC LIMIT 1";
                            $comando_last = $pdo->prepare($sql_last);
                            if($comando_last->execute()){
                                $id_credit = $comando_last->fetch();
                                $ord_credit = $id_credit["order_no_id"];
                                $ref_credit = $id_credit["reference_credit"];
                                $insert_pending = "insert into sales_pending (debtor_no_pending, order_no_pending, reference_pending, amount_total_pending,  ord_date_pending) values (:debtor_no_pending, :order_no_pending, :reference_pending, :amount_total_pending, :ord_date_pending)";
                                $comando_update_pending = $pdo->prepare($insert_pending);
                                $comando_update_pending->bindParam(":debtor_no_pending", $debtor_no);
                                $comando_update_pending->bindParam(":order_no_pending", $ord_credit);
                                $comando_update_pending->bindParam(":reference_pending", $ref_credit);
                                $comando_update_pending->bindParam(":amount_total_pending", $total);
                                $comando_update_pending->bindParam(":ord_date_pending", $data_final);
                                $comando_update_pending->execute();
                            }
                            //end pending



                                // Inventory Items Start
                                if(!empty($description)){
                                    foreach ($description as $key => $item) {
                                    // create salesOrderDetail Start
                                    $salesOrderDetail['order_no'] = $order_reference_id;
                                    $salesOrderDetail['stock_id'] = $stock_id[$key];
                                    $salesOrderDetail['description'] = $item;
                                    $salesOrderDetail['quantity'] = $itemQuantity[$key];
                                    $salesOrderDetail['trans_type'] = SALESORDER;
                                    $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
                                    $salesOrderDetail['tax_type_id'] = $taxIds[$key];
                                    $salesOrderDetail['unit_price'] = $unitPrice[$key];

                                    //Create salesOrderDetailInvoice Start
                                    $salesOrderDetailInvoice['order_no'] = $order_reference_id2;
                                    $salesOrderDetailInvoice['stock_id'] = $stock_id[$key];
                                    $salesOrderDetailInvoice['description'] = $description[$key];
                                    $salesOrderDetailInvoice['quantity'] = $itemQuantity[$key];
                                    $salesOrderDetailInvoice['trans_type'] = SALESINVOICE;
                                    $salesOrderDetailInvoice['discount_percent'] = $itemDiscount[$key];
                                    $salesOrderDetailInvoice['tax_type_id'] = $taxIds[$key];
                                    $salesOrderDetailInvoice['unit_price'] = $unitPrice[$key];

                                    $salesOrderDetailInvoice['tipo_operacao'] = 'credito';


                                    if($stock_id[$key]=="zero"){
                                        $salesOrderDetail['is_inventory'] = 0;
                                         $salesOrderDetailInvoice['is_inventory'] = 1;
                                    }
                                    else{
                                         $salesOrderDetail['is_inventory'] = 1;
                                          $salesOrderDetailInvoice['is_inventory'] = 1;
                                    }


                                    /*
                                    Create salesOrderDetailInvoice Start
                                    $salesOrderDetailInvoice['order_no'] = $order_reference_id2;
                                    $salesOrderDetailInvoice['stock_id'] = $stock_id[$key];
                                    $salesOrderDetailInvoice['description'] = $description[$key];
                                    $salesOrderDetailInvoice['quantity'] = $itemQuantity[$key];
                                    $salesOrderDetailInvoice['trans_type'] = SALESINVOICE;
                                    $salesOrderDetailInvoice['discount_percent'] = $itemDiscount[$key];
                                    $salesOrderDetailInvoice['tax_type_id'] = $taxIds[$key];
                                    $salesOrderDetailInvoice['unit_price'] = $unitPrice[$key];
                                    $salesOrderDetailInvoice['is_inventory'] = 1;
                                    DB::table('sales_order_details')->insertGetId($salesOrderDetailInvoice);
                                    // Create salesOrderDetailInvoice End
                                    */

                                    DB::table('sales_order_details')->insertGetId($salesOrderDetail);
                                    DB::table('sales_order_details')->insertGetId($salesOrderDetailInvoice);
                                     
                                    if($stock_id[$key]!="zero"){
                                        // create stockMove 
                                        $stockMove['stock_id'] = $stock_id[$key];
                                        $stockMove['loc_code'] = $request->from_stk_loc;
                                        $stockMove['tran_date'] = DbDateFormat($request->ord_date);
                                        $stockMove['person_id'] = $userId;
                                        $stockMove['reference'] = 'store_out_'.$order_reference_id2;
                                        $stockMove['transaction_reference_id'] =$order_reference_id2;
                                        $stockMove['qty'] = '-'.$itemQuantity[$key];
                                        $stockMove['trans_type'] = SALESINVOICE;
                                        $stockMove['order_no'] = $order_reference_id;
                                        $stockMove['order_reference'] = $order_reference_Gamb;
                                        DB::table('stock_moves')->insertGetId($stockMove);
                                   }     
                                }
                            }
                            // Inventory Items End
                            // Create salesOrder Invoice end
                        \Session::flash('success',trans('message.success.save_success'));
                        return redirect()->intended('invoice/view-detail-invoice-credito/'.$referenc.'/'.$reference);
                    }
                }}
            }//end gamb
        }//end insert indirect
        }
    }


    
     public function reporte(){
       
        $data['creditos'] = DB::table('sales_credito')
        ->leftjoin('sales_orders','sales_credito.order_no_id','=','sales_orders.order_no')
        ->leftjoin('debtors_master','sales_credito.debtor_no_credit','=','debtors_master.debtor_no')
        ->select("sales_orders.*", "sales_credito.*","debtors_master.*")->orderBy('credit_no', 'desc')
        ->get();

        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESINVOICE)->orderBy('ord_date','asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? date("d-m-Y", strtotime($fromDate->ord_date)) : date('d-m-Y'); 
        $data['to'] = $to = date('d-m-Y');

        $pdf = PDF::loadView('admin.sale.reports.creditoReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Factura'.time().'.pdf',array("Attachment"=>0));
    }

    public function reporteFilter($dataI,$dataF,$cust){

        $from = $dataI;
        $to = $dataF;
        $customer = $cust != "all" ? $cust : NULL;
        $location = NULL;   

        $from = DbDateFormat($from);
        $to = DbDateFormat($to);

        $data['from'] = $from;
        $data['to'] = $to;
       
        if($customer != NULL) {
            $data['creditos'] = DB::table('sales_credito')
                                ->leftjoin('sales_orders','sales_credito.order_no_id','=','sales_orders.order_no')
                                ->leftjoin('debtors_master','sales_credito.debtor_no_credit','=','debtors_master.debtor_no')
                                ->select("sales_orders.*", "sales_credito.*","debtors_master.*")->orderBy('credit_no', 'desc')
                                ->where('debtors_master.debtor_no','=',$customer)
                                ->where('sales_credito.credit_date','>=',$from)
                                ->where('sales_credito.credit_date','<=',$to)
                                ->get();
        } else {
            $data['creditos'] = DB::table('sales_credito')
                                ->leftjoin('sales_orders','sales_credito.order_no_id','=','sales_orders.order_no')
                                ->leftjoin('debtors_master','sales_credito.debtor_no_credit','=','debtors_master.debtor_no')
                                ->select("sales_orders.*", "sales_credito.*","debtors_master.*")->orderBy('credit_no', 'desc')
                                ->where('sales_credito.credit_date','>=',$from)
                                ->where('sales_credito.credit_date','<=',$to)
                                ->get();
        }

        $pdf = PDF::loadView('admin.sale.reports.creditoReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Factura'.time().'.pdf',array("Attachment"=>0));
    }


         // removendo o DebitoController
        public function destroy($id){
        
        // localizando a nota de debito                 
        $credito  = DB::table('sales_credito')
        ->leftjoin('sales_orders','sales_credito.order_no_id','=','sales_orders.order_no')
        ->leftjoin('debtors_master','sales_credito.debtor_no_credit','=','debtors_master.debtor_no')
        ->select("sales_orders.*", "sales_credito.*","debtors_master.*")->where('credit_no', $id)->first();
        
        //return $Debito->paid_amount_debit;  
        if($credito->paid_amount_credit!=0){

            \Session::flash('fail',trans('message.error.delete_debit'));
            return redirect()->intended('sales/credito');

         }else{   
              $UpdateStock=SockMove::where("order_no","=",$id)->get();
                if($UpdateStock!=null){

                    foreach ($UpdateStock as $UpdateStocks) {
                      if($UpdateStocks->stock_id!='zero'){
                            DB::table('stock_moves')
                            ->where('order_no', $id)->delete();
                            //->update(['qty' => 0]);     
                        }
                    }
                 } 
            
             // Abaixo querys perigosas    
            // Funcao abaixo=>Eliminado os detalhes da Notacredito     
            \DB::table('sales_order_details')->where('order_no', $id)->where('tipo_operacao', 'credito')->delete(); 

            // eliminado na tabela CC
            \DB::table('sales_cc')->where('reference_doc', $credito->reference_credit)->delete(); 

            // eliminado na tabela dos pendentes
            \DB::table('sales_pending')->where('reference_pending', $credito->reference_credit)->delete(); 

            // eliminando a nota Debito
             \DB::table('sales_credito')->where('reference_credit', $credito->reference_credit)->delete(); 
              
            \Session::flash('success',trans('message.success.delete_success'));
            return redirect()->intended('sales/credito');

        }
    }  




    
}
