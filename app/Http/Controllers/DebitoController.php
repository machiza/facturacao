<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Debitos;
use App\Http\Requests;
use App\Model\Creditos;
use App\Model\Credito;
use App\Model\SaleCC;
use App\Model\SockMove;
use App\Model\SalePending;
use DB;
use PDF;
use App\Http\Start\Helpers;

class DebitoController extends Controller
{
    public function __construct(Debitos $debitos){
     /**
     * Set the database connection. reference app\helper.php
     */   
        //selectDatabase();
        $this->sale = $debitos;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_debito';
        
         $data['debitos'] = DB::table('sales_debito')
        ->leftjoin('sales_orders','sales_debito.order_no_id','=','sales_orders.order_no')
        ->leftjoin('debtors_master','sales_debito.debtor_no_debit','=','debtors_master.debtor_no')
        ->select("sales_orders.*", "sales_debito.*","debtors_master.*")->orderBy('debit_no', 'desc')
        ->get();

        $data['Total_por_pagar'] = DB::table('sales_debito')->sum('debito');   
        $data['pago'] = DB::table('sales_debito')->sum('paid_amount_debit');   
        $data['saldo'] = $data['Total_por_pagar']-$data['pago'];

        // Novo 
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : NULL;
        $data['customerList'] = DB::table('debtors_master')->select('debtor_no','name')->where(['inactive'=>0])->get();

        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESINVOICE)->orderBy('ord_date','asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? formatDate(date("d-m-Y", strtotime($fromDate->ord_date))) : formatDate(date('d-m-Y')); 
        $data['to'] = $to = formatDate(date('d-m-Y')); 
        // End Novo

            //admin.sale.sales_debito
        return view('admin.sale.Sales_debito', $data);
        //return 'Sucesso';
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
        $data['sub_menu'] = 'sales/direct-invoice_debito';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);

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


        return view('admin.sale.debit_add', $data);
    }

    /**
     * Store a newly created resource in storage.
     **/

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
            $ord_date = $request->ord_date;
            $itemPrice = $request->item_price; 
            $taxainclusa = $request->taxainclusa;
            $type = $request->type;

            $taxTotal=0;  
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
            $NovaOrdem['debito'] = $request->total;
            if($request->reference_order_fact!=""){
                $NovaOrdem['order_no_id'] = $request->reference_order_fact;
            }
            $NovaOrdem['debit_date'] =  $data_final;
            $NovaOrdem['trans_type_debit'] =$trans_type_credit_indirect;
            $NovaOrdem['debtor_no_debit'] = $request->debtor_no;
            $NovaOrdem['person_id_debit'] = $userId;
            $NovaOrdem['reference_debit'] = $request->reference_debit;
            $NovaOrdem['invoice_type_debit'] = $invoice_type_credit;
            $NovaOrdem['from_stk_loc'] = $request->from_stk_loc;;            
            $NovaOrdem['payment_id_debit'] = $request->payment_id;         
            $NovaOrdem['payment_term_debit'] =$request->payment_term;           
            $NrNotaDebito= DB::table('sales_debito')->insertGetId($NovaOrdem);


            
             //$NrNotaCredito//debit_no
            //$NovaOrdem->credito_no

           

            $saida = "1";
            if($request->reference_order_fact!=""){
            // $TabelaCC->order_no_doc=$NrNotaDebito;
             $TabelaCC['order_no_doc'] =$NrNotaDebito; 
            }
            $TabelaCC['debtor_no_doc'] =$request->debtor_no;           
            $TabelaCC['credit_no_doc'] =$NrNotaDebito;;           
            $TabelaCC['reference_doc'] =$NovaOrdem['reference_debit'];   
            $TabelaCC['saldo_doc'] =$request->total; 
            $TabelaCC['amount_doc'] =$request->total;           
            $TabelaCC['debito_credito'] =$saida;           
            $TabelaCC['ord_date_doc'] =$data_final;           
            $IDTabelaCC= DB::table('sales_cc')->insertGetId($TabelaCC);

            $NovoSalePeding['reference_pending'] =$NovaOrdem['reference_debit'];
            $NovoSalePeding['amount_total_pending'] =$request->total;
            $NovoSalePeding['order_no_pending'] =$data_final;
            $NovoSalePeding['debtor_no_pending'] =$request->debtor_no;

            if($request->reference_order_fact!=""){
               $NovoSalePeding['ord_date_pending'] =$NovaOrdem['order_no_id'];
            }

            $IDNovoSalePeding= DB::table('sales_pending')->insertGetId($NovoSalePeding);
            
             
                
                // Inventory Items Start
                if(!empty($description)){
                    foreach ($description as $key => $item) {
                    // create salesOrderDetail Start order_reference_id
                    $salesOrderDetail['order_no'] = $NrNotaDebito;
                    $salesOrderDetail['stock_id'] = $stock_id[$key];
                    $salesOrderDetail['description'] = $description[$key]; 
                    $salesOrderDetail['quantity'] = $itemQuantity[$key];
                    $salesOrderDetail['trans_type'] = SALESORDER;
                    $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
                    $salesOrderDetail['tax_type_id'] = $taxIds[$key];
                    //$salesOrderDetail['unit_price'] = $unitPrice[$key];
                    $salesOrderDetail['tipo_operacao'] = 'debito';
                    
                    if($taxainclusa[$key]=='yes'){
                        $ptUnitario=$unitPrice[$key] - ($unitPrice[$key]*($itemDiscount[$key]/100));
                        $ptMontante= $itemPrice[$key]/$itemQuantity[$key];
                        $taxa=(($ptUnitario/$ptMontante)-1)*100;
                        $NovoPrecoUnitario=$unitPrice[$key]/(1+($taxa/100));

                        $salesOrderDetail['unit_price'] = $NovoPrecoUnitario;
                        $salesOrderDetail['taxa_inclusa_valor'] = "yes";

                       $priceAmount = ($itemQuantity[$key]*$NovoPrecoUnitario);
                       $discount = ($priceAmount*$itemDiscount[$key])/100;    

                    }else{
                         $salesOrderDetail['unit_price'] = $unitPrice[$key];
                         $salesOrderDetail['taxa_inclusa_valor'] = "no";

                       $priceAmount = ($itemQuantity[$key]*$unitPrice[$key]);
                       $discount = ($priceAmount*$itemDiscount[$key])/100; 
                         
                    }

                    $taxass = DB::table('item_tax_types')->where('id','=',$taxIds[$key])->first()->tax_rate;    
                    $newPrice = ($priceAmount-$discount);
                    $taxAmount = (($newPrice*$taxass)/100);
                    $taxTotal += $taxAmount;
                   

                     if($stock_id[$key]=="zero"){
                        $salesOrderDetail['is_inventory'] = 0;
                    }
                    else{
                         $salesOrderDetail['is_inventory'] = 1;
                    }
 
                    $IDdetalhes=  DB::table('sales_order_details')->insertGetId($salesOrderDetail);
                      

                    


                    // create stockMove
                   
                    if($type[$key]==0){

                                $stockMove['stock_id'] = $stock_id[$key];
                                $stockMove['order_no'] = $NrNotaDebito;
                                $data['tran_date'] = date("Y-m-d H:i:s");//
                                $stockMove['loc_code'] = $request->from_stk_loc;
                                $stockMove['person_id'] = $userId;
                                $stockMove['reference'] = 'store_out_'.$NrNotaDebito; 
                                $stockMove['order_reference'] =$NovaOrdem['reference_debit'];
                                $stockMove['qty'] = '-'.$itemQuantity[$key];
                                $stockMove['trans_type'] = SALESINVOICE;
                                $IDstockMove=DB::table('stock_moves')->insertGetId($stockMove);       

                     }
                 }
            }

            $Old['tax_total'] =$taxTotal;  
            DB::table('sales_debito')->where('debit_no','=',$NrNotaDebito)->update($Old);

           
                // Create salesOrder Invoice end
                \Session::flash('success',trans('message.success.save_success'));
                return redirect()->intended('invoice/view-detail-invoice-debito/'.$NrNotaDebito);
    }       



        //sales/add_debit/{id}/edit
        public function edit($id){

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_debito';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);


        $data['DebitoData'] = DB::table('sales_debito')->where('debit_no','=',$id)->first();  

        $data['DebitoDetalhes'] = $this->sale->getSalseInvoiceByID($id);  

        $novo = array();
        $elemento="";

        foreach ($data['DebitoDetalhes']  as $info) {
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


        return view('admin.sale.debit_edit', $data);
    }
   



    public function update(Request $request)
      {
            //return   $request->reference_debit;
            $userId = \Auth::user()->id;
            $itemQuantity = $request->item_quantity;        
            $itemIds = $request->item_id;
            $itemDiscount = $request->discount;
            $taxIds = $request->tax_id;
            $unitPrice = $request->unit_price;
            $stock_id = $request->stock_id;
            $description = $request->description;
            $ord_date = $request->ord_date;
            $itemPrice = $request->item_price; 
            $taxainclusa = $request->taxainclusa;
            $NrNotaDebito=$request->debito;

            
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
            $NovaOrdem['debito'] = $request->total;
            if($request->reference_order_fact!=""){
                $NovaOrdem['order_no_id'] = $request->reference_order_fact;
            }
            $NovaOrdem['debit_date'] =  $data_final;
            $NovaOrdem['trans_type_debit'] =$trans_type_credit_indirect;
            $NovaOrdem['debtor_no_debit'] = $request->debtor_no;
            $NovaOrdem['person_id_debit'] = $userId;
            $NovaOrdem['reference_debit'] = $request->reference_debit;
            $NovaOrdem['invoice_type_debit'] = $invoice_type_credit;
            $NovaOrdem['from_stk_loc'] = $request->from_stk_loc;;            
            $NovaOrdem['payment_id_debit'] = $request->payment_id;         
            $NovaOrdem['payment_term_debit'] =$request->payment_term;  
            DB::table('sales_debito')->where('debit_no','=',$NrNotaDebito)->update($NovaOrdem);
   
            $saida = "1";
            if($request->reference_order_fact!=""){
            // $TabelaCC->order_no_doc=$NrNotaDebito;
             $TabelaCC['order_no_doc'] =$NrNotaDebito; 
            }
            $TabelaCC['debtor_no_doc'] =$request->debito;     
            $TabelaCC['credit_no_doc'] =$NrNotaDebito;;           
            $TabelaCC['reference_doc'] =$NovaOrdem['reference_debit'];   
            $TabelaCC['saldo_doc'] =$request->total; 
            $TabelaCC['amount_doc'] =$request->total;           
            $TabelaCC['debito_credito'] =$saida;           
            $TabelaCC['ord_date_doc'] =$data_final;        

            DB::table('sales_cc')->where('reference_doc','=',$NovaOrdem['reference_debit'])->update($TabelaCC);

            $NovoSalePeding['reference_pending'] =$NovaOrdem['reference_debit'];
            $NovoSalePeding['amount_total_pending'] =$request->total;
            $NovoSalePeding['order_no_pending'] =$data_final;
            $NovoSalePeding['debtor_no_pending'] =$request->debtor_no;

            if($request->reference_order_fact!=""){
               $NovoSalePeding['ord_date_pending'] =$NovaOrdem['order_no_id'];
            }


             DB::table('sales_pending')->where('reference_pending','=',$NovaOrdem['reference_debit'])->update($NovoSalePeding);

             DB::table('sales_order_details')->where([['order_no','=',$NrNotaDebito],['tipo_operacao','=','debito']])->delete();

                if(!empty($description)){
                    foreach ($description as $key => $item) {
                    // create salesOrderDetail Start order_reference_id
                    $salesOrderDetail['order_no'] = $NrNotaDebito;
                    $salesOrderDetail['stock_id'] = $stock_id[$key];
                    $salesOrderDetail['description'] = $description[$key]; 
                    $salesOrderDetail['quantity'] = $itemQuantity[$key];
                    $salesOrderDetail['trans_type'] = SALESORDER;
                    $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
                    $salesOrderDetail['tax_type_id'] = $taxIds[$key];
                    //$salesOrderDetail['unit_price'] = $unitPrice[$key];
                    $salesOrderDetail['tipo_operacao'] = 'debito';
                    

                    if($taxainclusa[$key]=='yes'){
                        $ptUnitario=$unitPrice[$key] - ($unitPrice[$key]*($itemDiscount[$key]/100));
                        $ptMontante= $itemPrice[$key]/$itemQuantity[$key];
                        $taxa=(($ptUnitario/$ptMontante)-1)*100;
                        $NovoPrecoUnitario=$unitPrice[$key]/(1+($taxa/100));

                        $salesOrderDetail['unit_price'] = $NovoPrecoUnitario;
                        $salesOrderDetail['taxa_inclusa_valor'] = "yes";
                    }else{
                         $salesOrderDetail['unit_price'] = $unitPrice[$key];
                         $salesOrderDetail['taxa_inclusa_valor'] = "no";
                         
                    }

                     if($stock_id[$key]=="zero"){
                        $salesOrderDetail['is_inventory'] = 0;
                    }
                    else{
                         $salesOrderDetail['is_inventory'] = 1;
                    }
 
                     $IDdetalhes=  DB::table('sales_order_details')->insertGetId($salesOrderDetail);

                    DB::table('stock_moves')->where('reference','=','store_out_'.$NrNotaDebito)->delete();
                
                    if($stock_id[$key]==0){

                                $stockMove['stock_id'] = $stock_id[$key];
                                $stockMove['order_no'] = $NrNotaDebito;
                                $data['tran_date'] = date("Y-m-d H:i:s");//
                                $stockMove['loc_code'] = $request->from_stk_loc;
                                $stockMove['person_id'] = $userId;
                                $stockMove['reference'] = 'store_out_'.$NrNotaDebito;
                                $stockMove['order_reference'] =$NovaOrdem['reference_debit'];
                                $stockMove['qty'] = '-'.$itemQuantity[$key];
                                $stockMove['trans_type'] = SALESINVOICE;
                                $IDstockMove=DB::table('stock_moves')->insertGetId($stockMove);       

                     }
                 }
            }       

             

                // Create salesOrder Invoice end
                \Session::flash('success','Nota de Credito actualizada');
                return redirect()->intended('invoice/view-detail-invoice-debito/'.$NrNotaDebito);
    } 



        /**
    * Check reference no if exists
    */
    public function referenceValidation(Request $request){
        
        $data = array();
        $ref = $request['ref'];
        $result = DB::table('sales_debito')->where("reference_debit",$ref)->first();

        if(count($result)>0){
            $data['status_no'] = 1; 
        }else{
            $data['status_no'] = 0;
        }

        return json_encode($data);       
    }



      // repor
       public function reporte(){

        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESINVOICE)->orderBy('ord_date','asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? date("d-m-Y", strtotime($fromDate->ord_date)) : date('d-m-Y'); 
        $data['to'] = $to = date('d-m-Y');
       
        $data['debitos'] = DB::table('sales_debito')
        ->leftjoin('sales_orders','sales_debito.order_no_id','=','sales_orders.order_no')
        ->leftjoin('debtors_master','sales_debito.debtor_no_debit','=','debtors_master.debtor_no')
        ->select("sales_orders.*", "sales_debito.*","debtors_master.*")->orderBy('debit_no', 'desc')
        ->get();     

        /*$data['salesData'] = $this->sale->getAllSalseOrder($from = NULL, $to = NULL, $item = NULL, $customer = NULL, $location = NULL); */  

        $pdf = PDF::loadView('admin.sale.reports.debitoReport', $data);
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
            $data['debitos'] = DB::table('sales_debito')
                ->leftjoin('sales_orders','sales_debito.order_no_id','=','sales_orders.order_no')
                ->leftjoin('debtors_master','sales_debito.debtor_no_debit','=','debtors_master.debtor_no')
                ->select("sales_orders.*", "sales_debito.*","debtors_master.*")->orderBy('debit_no', 'desc')
                ->where('debtors_master.debtor_no','=',$customer)
                ->where('sales_orders.ord_date','>=',$from)
                ->where('sales_orders.ord_date','<=',$to)
                ->get();
        } else {
            $data['debitos'] = DB::table('sales_debito')
                ->leftjoin('sales_orders','sales_debito.order_no_id','=','sales_orders.order_no')
                ->leftjoin('debtors_master','sales_debito.debtor_no_debit','=','debtors_master.debtor_no')
                ->where('sales_orders.ord_date','>=',$from)
                ->where('sales_orders.ord_date','<=',$to)
                ->select("sales_orders.*", "sales_debito.*","debtors_master.*")->orderBy('debit_no', 'desc')
                ->get();
        }
         

        $pdf = PDF::loadView('admin.sale.reports.debitoReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Factura'.time().'.pdf',array("Attachment"=>0));
    }



        // removendo o DebitoController
        public function destroy($id){
        //return "venda nao no estado normal deve ser feito o rollback de tudo feito";

                  // localizando a nota de debito                 
       // return    $Debito=DB::table('sales_debito')->where('debit_no', $id)->get(); 

        $Debito  = DB::table('sales_debito')
        ->leftjoin('sales_orders','sales_debito.order_no_id','=','sales_orders.order_no')
        ->leftjoin('debtors_master','sales_debito.debtor_no_debit','=','debtors_master.debtor_no')
        ->select("sales_orders.*", "sales_debito.*","debtors_master.*")->where('debit_no', $id)->first();
        
        //return $Debito->paid_amount_debit;

        if($Debito->paid_amount_debit!=0){

            \Session::flash('fail',trans('message.error.delete_debit'));
            return redirect()->intended('sales/debito');

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
            \DB::table('sales_order_details')->where('order_no', $id)->where('tipo_operacao', 'debito')->delete(); 

            // eliminado na tabela CC
            \DB::table('sales_cc')->where('reference_doc', $Debito->reference_debit)->delete(); 

            // eliminado na tabela dos pendentes
            \DB::table('sales_pending')->where('reference_pending', $Debito->reference_debit)->delete(); 

            // eliminando a nota Debito
             \DB::table('sales_debito')->where('reference_debit', $Debito->reference_debit)->delete(); 
              
            \Session::flash('success',trans('message.success.delete_success'));
            return redirect()->intended('sales/debito');

        }
    }  

}
