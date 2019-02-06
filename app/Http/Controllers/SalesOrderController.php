<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\EmailController;
use App\Model\Orders;
use App\Http\Requests;
use App\Model\Sales;
use App\Model\Shipment;
use DB;
use PDF;
use Session;
use App\Http\Start\Helpers;


class SalesOrderController extends Controller
{
    public function __construct(Orders $orders,Sales $sales,Shipment $shipment,EmailController $email){

        $this->order = $orders;
        $this->sale = $sales;
        $this->shipment = $shipment;
        $this->email = $email;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';
        $data['orderData'] = $this->order->getAllSalseOrder(NULL, NULL, NULL, NULL);
        return view('admin.salesOrder.orderList', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderFiltering()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';

        $data['location'] = $location = isset($_GET['location']) ? $_GET['location'] : NULL;
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : NULL;

        $data['customerList'] = DB::table('debtors_master')->select('debtor_no','name')->where(['inactive'=>0])->get();
        $data['locationList'] = DB::table('location')->select('loc_code','location_name')->get();

        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESORDER)->orderBy('ord_date','asc')->first();
    
        $data['from'] = $from = isset($fromDate->ord_date) ? formatDate(date("d-m-Y", strtotime($fromDate->ord_date))) : date("d-m-Y");
        
        $data['to'] = $to = formatDate(date('d-m-Y'));

        $data['orderData'] = $this->order->getAllSalseOrder($from, $to, $location, $customer);
        
        return view('admin.salesOrder.orderListFilter', $data);
    }

    /**
     * Show the form for creating a new resource.
     **/
    public function create()
    {

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();
        $data['locData'] = DB::table('location')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);

        $data['salesType'] = DB::table('sales_types')->select('sales_type','id','defaults')->get();
       
        $order_count = DB::table('sales_orders')->where('trans_type',SALESORDER)->count();

        if($order_count>0){
        $orderReference = DB::table('sales_orders')->where('trans_type',SALESORDER)->select('reference')->orderBy('order_no','DESC')->first();
        $ref = explode("-",$orderReference->reference);
        $data['order_count'] = (int) $ref[1];
        }else{
            $data['order_count'] = 0 ;
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

        $data['moedas'] = DB::table('taxas')
        ->join('moedas','moedas.id','=','taxas.moedas_id') 
        ->get();

        return view('admin.salesOrder.orderAdd', $data);
    }

   public function taxasCambio (){

        $data = DB::table('taxas')
        ->join('moedas','moedas.id','=','taxas.moedas_id') 
        ->get();
    return $data;
    }

    //Store com novas funcionalidades
    public function store(Request $request)
    {
       
       $userId = \Auth::user()->id;
        
        if($request->customer_new=="" || $request->customer_new_nuit==""){
            $this->validate($request, [
            'reference'=>'required|unique:sales_orders',
            'from_stk_loc' => 'required',
            'ord_date' => 'required',
            'debtor_no' => 'required',
            'payment_id' => 'required',
         
        ]);
    
        }else{
            $this->validate($request, [
            'reference'=>'required|unique:sales_orders',
            'from_stk_loc' => 'required',
            'ord_date' => 'required',
            'payment_id' => 'required',
            ]);
        
        }
        
       DB::beginTransaction();

    try {
        

        if($request->customer_new!="" || $request->customer_new_nuit!=""){
            $data['name'] = $request->customer_new;
            $data['phone'] = $request->customer_new_telemovel;
            $data['sales_type'] =0;
            $data['status_debtor'] ='desactivo';
            $data['created_at'] = date('Y-m-d H:i:s');
            $cliente = DB::table('debtors_master')->insertGetId($data);
            $data2['debtor_no'] = $cliente;
            $data2['br_name'] = $request->customer_new;
            $data2['nuit'] = $request->customer_new_nuit;
            DB::table('cust_branch')->insert($data2);
        }   


        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $description = $request->description;
        $stock_id = $request->stock_id;
        $taxainclusa = $request->taxainclusa;
        $itemPrice = $request->item_price; 

        

        if(!empty($itemIds)){
        foreach ($itemQuantity as $key => $itemQty) {
            $product[$itemIds[$key]] = $itemQty;
         }
        }

        // create salesOrder 
        if($request->customer_new!="" || $request->customer_new_nuit!=""){
            $salesOrder['debtor_no'] = $cliente;
            $salesOrder['branch_id'] = $cliente;
        }else{
            $salesOrder['debtor_no'] = $request->debtor_no;
            $salesOrder['branch_id'] = $request->debtor_no;
        }

        $salesOrder['payment_id']= $request->payment_id;
        $salesOrder['person_id']= $userId;
        $salesOrder['reference'] = $request->reference;
        $salesOrder['comments'] = $request->comments;
        $salesOrder['trans_type'] = SALESORDER;
        $salesOrder['invoice_type'] = 'directOrder';
        $salesOrder['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrder['from_stk_loc'] = $request->from_stk_loc;
        $salesOrder['payment_term'] = 2;
        $salesOrder['total'] = $request->total;
        $salesOrder['created_at'] = date('Y-m-d H:i:s');
        $salesOrder['requisicao'] = $request->requisicao;
        $salesOrderId = \DB::table('sales_orders')->insertGetId($salesOrder);

        
        if(count($itemIds)>0){
        for ($i=0; $i < count($itemIds); $i++) {
            foreach ($product as $key => $item) {
                
                if($itemIds[$i] == $key){
                    // create salesOrderDetail 
                    $salesOrderDetail[$i]['order_no'] = $salesOrderId;
                    $salesOrderDetail[$i]['stock_id'] = $stock_id[$i];
                    $salesOrderDetail[$i]['description'] = $description[$i];
                    $salesOrderDetail[$i]['quantity'] = $itemQuantity[$i];
                    $salesOrderDetail[$i]['trans_type'] = SALESORDER;
                    $salesOrderDetail[$i]['discount_percent'] = $itemDiscount[$i];
                    $salesOrderDetail[$i]['tipo_operacao']= "";
                    $salesOrderDetail[$i]['tax_type_id'] = $taxIds[$i];

                    if($taxainclusa[$i]=='yes'){
                       
                        $ptUnitario=$unitPrice[$i] - ($unitPrice[$i]*($itemDiscount[$i]/100));
                        $ptMontante= $itemPrice[$i]/$itemQuantity[$i];
                        $taxa=(($ptUnitario/$ptMontante)-1)*100;

                        $NovoPrecoUnitario=$unitPrice[$i]/(1+($taxa/100));
                        $salesOrderDetail[$i]['unit_price'] = $NovoPrecoUnitario;
                        $salesOrderDetail[$i]['taxa_inclusa_valor'] = "yes";
                    }else{
                         $salesOrderDetail[$i]['unit_price'] = $unitPrice[$i];
                         $salesOrderDetail[$i]['taxa_inclusa_valor'] = "no";
                         
                    }
                    

                    if( $stock_id[$i]=="zero"){
                        $items['is_inventory'] = 0;        
                    }else{
                        $salesOrderDetail[$i]['qty_sent'] = 0;
                        $salesOrderDetail[$i]['is_inventory'] = 1;
                 
                    }           
                }
            }
        }
        }
        
        if(count($itemIds) > 0){
        for ($i=0; $i < count($salesOrderDetail); $i++) { 
            
            DB::table('sales_order_details')->insertGetId($salesOrderDetail[$i]);
        }
    }

    
         DB::commit();
          // all good
     } catch (\Exception $e) {
        DB::rollback();
          // something went wrong
   }
             
        if(!empty($salesOrderId)){
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('order/view-order-details/'.$salesOrderId);
        }

    }

 


    public function edit($orderNo)
    {
        $data['invoiceData'] = $this->order->getSalseInvoiceByID($orderNo);
        $novo = array();
        $elemento="";

        foreach ($data['invoiceData']  as $info) {
               if($info->item_id!=null){
                    array_push($novo,$info->item_id);
                    $elemento=$info->item_id.'/'.$elemento;
                }
        }

        $data['elementos'] =$elemento;
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';
        $data['locData'] = DB::table('location')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id','defaults')->get();
       

        $order_count = DB::table('sales_orders')->where('trans_type',SALESORDER)->count();

        if($order_count>0){
        $orderReference = DB::table('sales_orders')->where('trans_type',SALESORDER)->select('reference')->orderBy('order_no','DESC')->first();
        $ref = explode("-",$orderReference->reference);
        $data['order_count'] = (int) $ref[1];
        }else{
            $data['order_count'] = 0 ;
        }

        $data['saleData'] = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();
        $data['branchs'] = DB::table('cust_branch')->select('debtor_no','branch_code','br_name')->where('debtor_no',$data['saleData']->debtor_no)->orderBy('br_name','ASC')->get();
        
        $data['invoicedItem'] = DB::table('stock_moves')->where(['order_no'=>$orderNo])->lists('stock_id');
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id','defaults')->get();
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
        $data['customerData']= DB::table('debtors_master')->where(['inactive'=>0])
                             ->where('status_debtor','!=','desactivo')
                             ->Orwhere('debtor_no','=',$data['saleData']->debtor_no)
                              ->get();                    

        $data['estadoCliente']= DB::table('debtors_master')
                           ->leftJoin('cust_branch','cust_branch.debtor_no','=','debtors_master.debtor_no')
                            ->where('debtors_master.debtor_no','=',$data['saleData']->debtor_no)->first();


        if($data['estadoCliente']->status_debtor=="desactivo"){
        $data['clienteGenerico'] = "yes"; 

        }else{
        $data['clienteGenerico'] = "no"; 

        }                     
         
        return view('admin.salesOrder.orderEdit', $data);
       
   }



     //@shady the new update function 
     public function update(Request $request)
     {
        $userId = \Auth::user()->id;
        $order_no = $request->order_no;
        $this->validate($request, [
            'from_stk_loc' => 'required',
            'ord_date' => 'required',
             //'debtor_no' => 'required',
            'payment_id' => 'required'
        ]);
            
            $ClienteNovo=0;
       
         if($request->customer_new!="" || $request->customer_new_nuit!=""){
            $data['name'] = $request->customer_new;
            $data['phone'] = $request->customer_new_telemovel;
            $data['created_at'] = date('Y-m-d H:i:s');
            DB::table('debtors_master')->where('debtor_no', $request->customer_Old_id)->update($data);
            $data2['br_name'] = $request->customer_new;
            $data2['nuit'] = $request->customer_new_nuit;
            DB::table('cust_branch')->where('debtor_no', $request->customer_Old_id)->update($data2);
            $ClienteNovo=$request->customer_Old_id;

        }else{
              $ClienteNovo=$request->debtor_no;
        }  

            $itemQuantity = $request->item_quantity;        
            $itemIds = $request->item_id;
            $itemDiscount = $request->discount;
            $taxIds = $request->tax_id;
            $unitPrice = $request->unit_price;
            $description = $request->description;
            $stock_id = $request->stock_id;
            $taxainclusa = $request->taxainclusa;
            $itemPrice = $request->item_price; 

        
        if(!empty($itemIds)){
        foreach ($itemQuantity as $key => $itemQty) {
            $product[$itemIds[$key]] = $itemQty;
         }
        }
        
        $salesOrder['debtor_no'] =  $request->debtor_no;
        $salesOrder['payment_id']= $request->payment_id;
        $salesOrder['person_id']= $userId;
        $salesOrder['reference'] = $request->reference;
        $salesOrder['comments'] = $request->comments;
        $salesOrder['trans_type'] = SALESORDER;
        $salesOrder['invoice_type'] = 'directOrder';
        $salesOrder['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrder['from_stk_loc'] = $request->from_stk_loc;
        $salesOrder['payment_term'] = 2;
        $salesOrder['total'] = $request->total;
        $salesOrder['created_at'] = date('Y-m-d H:i:s');
        $salesOrder['requisicao'] = $request->requisicao;
        $salesOrder['debtor_no'] = $ClienteNovo;
        $salesOrder['branch_id'] = $ClienteNovo;


        DB::table('sales_orders')->where('order_no', $order_no)->update($salesOrder);

        DB::table('sales_order_details')->where('order_no',$order_no)->delete();

        if(count($itemIds)>0){
        for ($i=0; $i < count($itemIds); $i++) {
            foreach ($product as $key => $item) {
                
                if($itemIds[$i] == $key){
                    // create salesOrderDetail 
                    $salesOrderDetail[$i]['order_no'] = $order_no;
                    $salesOrderDetail[$i]['stock_id'] = $stock_id[$i];
                    $salesOrderDetail[$i]['description'] = $description[$i];
                    //$salesOrderDetail[$i]['quantity'] = $item[$i];
                    $salesOrderDetail[$i]['quantity'] = $itemQuantity[$i];
                    $salesOrderDetail[$i]['trans_type'] = SALESORDER;
                    $salesOrderDetail[$i]['discount_percent'] = $itemDiscount[$i];
                    $salesOrderDetail[$i]['tipo_operacao']= "";
                    $salesOrderDetail[$i]['tax_type_id'] = $taxIds[$i];

                    if($taxainclusa[$i]=='yes'){
                       
                        $ptUnitario=$unitPrice[$i] - ($unitPrice[$i]*($itemDiscount[$i]/100));
                        $ptMontante= $itemPrice[$i]/$itemQuantity[$i];
                        $taxa=(($ptUnitario/$ptMontante)-1)*100;

                        $NovoPrecoUnitario=$unitPrice[$i]/(1+($taxa/100));
                        $salesOrderDetail[$i]['unit_price'] = $NovoPrecoUnitario;
                        $salesOrderDetail[$i]['taxa_inclusa_valor'] = "yes";
                    }else{
                         $salesOrderDetail[$i]['unit_price'] = $unitPrice[$i];
                         $salesOrderDetail[$i]['taxa_inclusa_valor'] = "no";
                         
                    }
                    
                    if( $stock_id[$i]=="zero"){
                        $items['is_inventory'] = 0;        
                    }else{
                        $salesOrderDetail[$i]['qty_sent'] = 0;
                        $salesOrderDetail[$i]['is_inventory'] = 1;
                    }           
                 }
             }
          }
        }
        
        if(count($itemIds) > 0){
        for ($i=0; $i < count($salesOrderDetail); $i++) { 
            
             DB::table('sales_order_details')->insertGetId($salesOrderDetail[$i]);
          }
       }

        \Session::flash('success',trans('message.success.save_success'));
         return redirect()->intended('order/view-order-details/'.$order_no);
        

    }










    /**
     * Remove the specified resource from storage.
     **/
    public function destroy($id)
    {
        
        if(isset($id)) {
         $record = \DB::table('sales_orders')->where('order_no', $id)->first();
            if($record) {

                // Delete invoice information
                  $invoice = \DB::table('sales_orders')->where('order_reference_id', $record->order_no)->first();
              
                 DB::table('sales_orders')->where('order_no', '=', $id)->delete();
                if(!empty($invoice)){
                     DB::table('sales_order_details')->where('order_no', '=', $invoice->order_no)->delete();
                }

                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('order/list');
            }
        }
    }


    public function search(Request $request)
    {
          

            $data = array();
            $data['status_no'] = 0;
            $data['message']   ='No Item Found!';
            $data['items'] = array();
        
             $item = DB::table('stock_master')
            ->where('stock_master.description','LIKE','%'.$request->search.'%')
            ->where(['stock_master.inactive'=>0,'stock_master.deleted_status'=>0])
            ->orWhere('stock_master.stock_id','LIKE','%'.$request->search.'%')
            ->leftJoin('item_tax_types','item_tax_types.id','=','stock_master.tax_type_id')
            ->leftJoin('item_code','stock_master.stock_id','=','item_code.stock_id')
            ->leftJoin('purchase_prices','stock_master.stock_id','=','purchase_prices.stock_id')
            ->select('stock_master.*','item_tax_types.tax_rate','item_tax_types.id as tax_id','item_code.id','item_code.item_type_id','purchase_prices.price as preco_compra')
            ->get();


             
            if(!empty($item)){
                
                $data['status_no'] = 1;
                $data['message']   ='Item Found';

                $i = 0;
                foreach ($item as $key => $value) {
                    $itemPriceValue = DB::table('sale_prices')->where(['stock_id'=>$value->stock_id,'sales_type_id'=>$request['salesTypeId']])->select('price','inclusao_iva','discounto')->first();
                    
                     $inclusao_iva=$itemPriceValue->inclusao_iva;

                    if(!isset($itemPriceValue)){
                        $itemSalesPriceValue = 0;
                    }else{
                        $itemSalesPriceValue = $itemPriceValue->price;
                    }

                    $return_arr[$i]['id'] = $value->id;
                    $return_arr[$i]['stock_id'] = $value->stock_id;
                    $return_arr[$i]['description'] = $value->description;
                    $return_arr[$i]['units'] = $value->units;
                    $return_arr[$i]['price'] = $itemSalesPriceValue;
                    $return_arr[$i]['tax_rate'] = $value->tax_rate;
                    $return_arr[$i]['tax_id'] = $value->tax_id;
                    $return_arr[$i]['inclusao_iva'] = $inclusao_iva;
                    $return_arr[$i]['servico']=$value->item_type_id;
                    $i++;
                }
                //echo json_encode($return_arr);
                 $data['items'] = $return_arr;
            }
            echo json_encode($data);
            exit;            
    }

    /**
    * Check reference no if exists
    */
    public function referenceValidation(Request $request){
        
        $data = array();
        $ref = $request['ref'];
        $result = DB::table('sales_orders')->where("reference",$ref)->first();

        if(count($result)>0){
            $data['status_no'] = 1; 
        }else{
            $data['status_no'] = 0;
        }

        return json_encode($data);       
    }

    /**
    * Return customer Branches by customer id
    */
    public function customerBranches(Request $request){
        $debtor_no = $request['debtor_no'];
        $data['status_no'] = 0;
        $branchs = '';
        $result = DB::table('cust_branch')->select('debtor_no','branch_code','br_name')->where('debtor_no',$debtor_no)->orderBy('br_name','ASC')->get();
        if(!empty($result)){
            $data['status_no'] = 1;
            foreach ($result as $key => $value) {
            $branchs .= "<option value='".$value->branch_code."'>".$value->br_name."</option>";  
        }
        $data['branchs'] = $branchs; 
       }
        return json_encode($data);
    }

   

    /**
    * Preview of order details
    * @params order_no
    **/

    public function viewOrderDetails($orderNo){

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';

        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        $data['invoiceType'] = $data['saleData']->invoice_type;
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);

        if($data['invoiceData']==null){

          $result= DB::table('sales_orders')->where('order_reference_id','=',$orderNo)->select("sales_orders.*")->first();

         $codigo=$result->order_no;

          //$orderNo1=$orderNo+1;

          $data['invoiceData'] = $this->order->getSalseOrderByID($codigo,$data['saleData']->from_stk_loc);
        }


//d($data['saleData'],1);
        
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                            // ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                              ->leftjoin('cust_branch','cust_branch.debtor_no','=','debtors_master.debtor_no')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country', 'sales_orders.*')
                             ->first();        
       

      
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no')->first();
        $data['paymentsList'] = DB::table('payment_history')
                            ->where(['order_reference'=>$data['orderInfo']->reference])
                            ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                            ->select('payment_history.*','payment_terms.name')
                            ->orderBy('payment_date','DESC')
                            ->get();
        $lang = Session::get('dflt_lang');
        $data['emailInfo'] = DB::table('email_temp_details')->where(['temp_id'=>5,'lang'=>$lang])->select('subject','body')->first();
        $checkInvoiced = DB::table('sales_orders')->where('order_reference_id',$orderNo)->first();
        if($checkInvoiced){
          $data['invoiced_date'] = $checkInvoiced->ord_date;
          $data['invoiced_status'] = 'yes';
        }else{
          $data['invoiced_status'] = 'no';
         }
        return view('admin.salesOrder.viewOrderDetails', $data);

    }
    /**
    * Create auto invoice
    *@params order_id
    */

    public function autoInvoiceCreate($orderNo){
        $userId = \Auth::user()->id;
        $invoiceCount = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->count();
       
        if($invoiceCount>0){
        $invoiceReference = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->select('reference')->orderBy('order_no','DESC')->first();

        $ref = explode("-",$invoiceReference->reference);
        $invoice_count = (int) $ref[1];
        }else{
            $invoice_count = 0 ;
        }

        $invoiceInfos = $this->order->getRestOrderItemsByOrderID($orderNo);
        $orderInfo = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();

        DB::table('debtors_master')->where('debtor_no', $orderInfo->debtor_no)->update(['status_debtor' =>""]);

        $payment_term = DB::table('invoice_payment_terms')->where('defaults',1)->select('id')->first();

        //Data da cricao da factura
        $dt = date("Y/m/d");
        $parte_ano = substr($dt,  0, 4);

        $salesOrderInvoice['order_reference_id'] = $orderNo;
        $salesOrderInvoice['order_reference'] = $orderInfo->reference;
        $salesOrderInvoice['trans_type'] = SALESINVOICE;
        $salesOrderInvoice['invoice_type'] = 'directInvoice';
        $salesOrderInvoice['reference'] ='FT-'.sprintf("%04d", $invoice_count+1).'/'. $parte_ano;
        $salesOrderInvoice['debtor_no'] = $orderInfo->debtor_no;
        $salesOrderInvoice['branch_id'] = $orderInfo->branch_id;
        $salesOrderInvoice['person_id']= $userId;
        $salesOrderInvoice['payment_id']= $orderInfo->payment_id;
        $salesOrderInvoice['comments'] = $orderInfo->comments;
        $salesOrderInvoice['ord_date'] = $orderInfo->ord_date;
        $salesOrderInvoice['from_stk_loc'] = $orderInfo->from_stk_loc;
        $salesOrderInvoice['payment_term']= 2;
        $salesOrderInvoice['total'] = $orderInfo->total;

        $salesOrderInvoice['created_at'] = date('Y-m-d H:i:s');        

        $orderInvoiceId = DB::table('sales_orders')->insertGetId($salesOrderInvoice);

        $entra="1";
        // Colocando os dados 
        $salesInvoiceR['debtor_no_doc'] =   $orderInfo->debtor_no;
        $salesInvoiceR['order_no_doc'] = $orderNo;
        $salesInvoiceR['reference_doc'] = 'FT-'.sprintf("%04d", $invoice_count+1).'/'. $parte_ano;
        $salesInvoiceR['order_reference_doc'] =  $orderInfo->reference;
        $salesInvoiceR['amount_doc'] =$orderInfo->total;
        $salesInvoiceR['saldo_doc'] = $orderInfo->total;
        $salesInvoiceR['debito_credito'] = $entra; 

        $salesInvoiceR['ord_date_doc'] =$orderInfo->ord_date;
        $salesInvoiceRID = DB::table('sales_cc')->insertGetId($salesInvoiceR);
        
    
        foreach($invoiceInfos as $i=>$invoiceInfo){

            $salesOrderDetailInvoice['order_no'] = $orderInvoiceId;
            $salesOrderDetailInvoice['stock_id'] = $invoiceInfo->stock_id;
            $salesOrderDetailInvoice['description'] = $invoiceInfo->description;
            $salesOrderDetailInvoice['quantity'] = $invoiceInfo->quantity;
            $salesOrderDetailInvoice['trans_type'] = SALESINVOICE;
            $salesOrderDetailInvoice['discount_percent'] = $invoiceInfo->discount_percent;
            $salesOrderDetailInvoice['tax_type_id'] = $invoiceInfo->tax_type_id;
            $salesOrderDetailInvoice['unit_price'] = $invoiceInfo->unit_price;
            $salesOrderDetailInvoice['is_inventory'] = $invoiceInfo->is_inventory;
            $salesOrderDetailInvoice['tipo_operacao']= "";
            
            DB::table('sales_order_details')->insertGetId($salesOrderDetailInvoice);
            // Create salesOrderDetailInvoice End

            // create stockMove 
            if($invoiceInfo->is_inventory == 1){
                $stockMove['stock_id'] = $invoiceInfo->stock_id;
                $stockMove['order_no'] = $orderNo;
                $stockMove['loc_code'] = $orderInfo->from_stk_loc;
                $stockMove['tran_date'] = date('Y-m-d');
                $stockMove['person_id'] = $userId;
                $stockMove['reference'] = 'store_out_'.$orderInvoiceId;
                $stockMove['transaction_reference_id'] = $orderInvoiceId;
                $stockMove['qty'] = '-'.$invoiceInfo->quantity;
                $stockMove['price'] = $invoiceInfo->unit_price;
                $stockMove['trans_type'] = SALESINVOICE;
                $stockMove['order_reference'] = $orderInfo->reference;
                DB::table('stock_moves')->insertGetId($stockMove);
        }
       
        }
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('invoice/view-detail-invoice/'.$orderNo.'/'.$orderInvoiceId);
    }


    /**
    * Preview of order details
    * @params order_no
    **/

    public function orderPdf($orderNo){
       
        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();
        
        $pdf = PDF::loadView('admin.salesOrder.orderPrint', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('order_'.time().'.pdf',array("Attachment"=>0));
    }


    public function orderPrint($orderNo){
       
        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();
       
        $pdf = PDF::loadView('admin.salesOrder.orderPrint', $data);
       $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('order_'.time().'.pdf',array("Attachment"=>0));
    
        return view('admin.salesOrder.orderPrint', $data);
    }
    /**
    * Send email to customer for Invoice information
    */
    public function sendOrderInformationByEmail(Request $request){
        
        $orderNo = $request['order_id'];
        $invoiceName = 'quotation.pdf';

        if(isset($request['quotation_pdf']) && $request['quotation_pdf']=='on'){
            $this->orderPdfEmail($orderNo,$invoiceName);
            $this->email->sendEmailWithAttachment($request['email'],$request['subject'],$request['message'],$invoiceName);
         }else{
            $this->email->sendEmail($request['email'],$request['subject'],$request['message']);
         } 

        \Session::flash('success',trans('message.email.email_send_success'));
        return redirect()->intended('order/view-order-details/'.$request['order_id']);
    }


    public function orderPdfEmail($orderNo,$invoiceName){

        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();
        
        $pdf = PDF::loadView('admin.salesOrder.orderPdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->save(public_path().'/uploads/invoices/'.$invoiceName);        
    }


     // repor
       public function reporte(){

        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESORDER)->orderBy('ord_date','asc')->first();
    
        $data['from'] = $from = isset($fromDate->ord_date) ? date("d-m-Y", strtotime($fromDate->ord_date)) : date("d-m-Y");
        
        $data['to'] = $to = date('d-m-Y');
       
        //$data['salesData'] = $this->sale->getAllSalseOrder($from = NULL, $to = NULL, $item = NULL, $customer = NULL, $location = NULL);
        $data['orderData'] = $this->order->getAllSalseOrder(NULL, NULL, NULL, NULL);
        $pdf = PDF::loadView('admin.salesOrder.reports.saleOrderReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Factura'.time().'.pdf',array("Attachment"=>0));
    }

    public function reporte_pdf($dataI,$dataF,$cust) {

        $from = $dataI;
        $to = $dataF;
        $customer = $cust != "all" ? $cust : NULL;
        $location = NULL;

        $data['from'] = $from;
        $data['to'] = $to;
       
        //$data['salesData'] = $this->sale->getAllSalseOrder($from = NULL, $to = NULL, $item = NULL, $customer = NULL, $location = NULL);
        $data['orderData'] = $this->order->getAllSalseOrder($from, $to, $location, $customer);
        $pdf = PDF::loadView('admin.salesOrder.reports.saleOrderReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Factura'.time().'.pdf',array("Attachment"=>0));
    }

}
