<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Sales;
use App\Model\Orders;
use App\Model\SockMove;
use App\Model\SaleCC;
use App\Http\Requests;
use DB;
use PDF;
use App\Http\Start\Helpers;

class SalesController extends Controller
{
    public function __construct(Sales $sales){
     /**
     * Set the database connection. reference app\helper.php
     */   
        $this->middleware('auth');
        //selectDatabase();
        $this->sale = $sales;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice';
        $data['salesData'] = $this->sale->getAllSalseOrder($from = NULL, $to = NULL, $item = NULL, $customer = NULL, $location = NULL);

        //$total = DB::table('posts')->sum('views');
        

       $data['PrecoTotal']=DB::table('sales_orders')->where('status', '!=','cancelado')->orWhere('status','=',null)->where('invoice_type', '=', 'directInvoice')->sum('total');

       $data['PrecoPago']=DB::table('sales_orders')->where('status', '!=','cancelado')->orWhere('status','=',null)->where('invoice_type', '=', 'directInvoice')->sum('paid_amount');

       
        


        return view('admin.sale.sales_list', $data);



    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function salesFiltering()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice';

        $data['location'] = $location = isset($_GET['location']) ? $_GET['location'] : NULL;
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : NULL;

        $data['customerList'] = DB::table('debtors_master')->select('debtor_no','name')->where(['inactive'=>0])->get();
        $data['locationList'] = DB::table('location')->select('loc_code','location_name')->get();
        
        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESINVOICE)->orderBy('ord_date','asc')->first();
        
        if(isset($_GET['from'])){
            $data['from'] = $from = $_GET['from'];
        }else{
           $data['from'] = $from = isset($fromDate->ord_date) ? formatDate(date("d-m-Y", strtotime($fromDate->ord_date))) : date('d-m-Y'); 
        }
        
        if(isset($_GET['to'])){
            $data['to'] = $to = $_GET['to'];
        }else{
            $data['to'] = $to = formatDate(date('d-m-Y'));
        }


        $data['salesData'] = $this->sale->getAllSalseOrder($from, $to, $customer, $location);
        return view('admin.sale.sales_list_filter', $data);
    }

    public function salesFiltering_pdf($dataI,$dataF,$cust)
    {
        $from = $dataI;
        $to = $dataF;
        $customer = $cust;
        $location = NULL;


        $data['salesData'] = $this->sale->getAllSalseOrder($from, $to, $customer, $location);
        
        $pdf = PDF::loadView('admin.salesOrder.reports.saleReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Factura'.time().'.pdf',array("Attachment"=>0));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice';
        $data['sub_menu'] = 'sales/direct-invoice';
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);
        //$data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->get();
        
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();
        $data['locData'] = DB::table('location')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        //d($data['payments'],1);
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();
        $invoice_count = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->count();
        
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get();        
        
        if($invoice_count>0){
        $invoiceReference = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->select('reference')->orderBy('order_no','DESC')->first();

        $ref = explode("-",$invoiceReference->reference);
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
        

        return view('admin.sale.sale_add', $data);
    }



    /**
     * Store a newly created resource in storage.
     **/
    public function store(Request $request)
    {
     $this->validate($request, [
            'reference'=>'required|unique:sales_orders',
            'from_stk_loc' => 'required',
            'ord_date' => 'required',
            'debtor_no' => 'required',
            //'branch_id' => 'required',
            'payment_id' => 'required',
           // 'item_quantity' => 'required',
        ]);

        $taxTotal =0;
        DB::beginTransaction();
       

        $userId = \Auth::user()->id;
        $debtor = $request->debtor_no;
        $grand_total = $request->total;

        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $stock_id = $request->stock_id;
        $description = $request->description;
        $taxainclusa = $request->taxainclusa;
        $itemPrice = $request->item_price; 
        $preco_comp = $request->preco_comp; 
        $type = $request->type;
        $dt = date("Y/m/d");
        $parte_ano = substr($dt,  0, 4); 
       
        // create salesOrder start
        $orderReferenceNo = DB::table('sales_orders')->where('trans_type',SALESORDER)->count();

        if($orderReferenceNo>0){
        $orderReference = DB::table('sales_orders')->where('trans_type',SALESORDER)->select('reference')->orderBy('order_no','DESC')->first();
        $ref = explode("-",$orderReference->reference);
        $orderCount = (int) $ref[1];
        }else{
            $orderCount = 0 ;
        }
       
        $salesOrder['debtor_no'] = $request->debtor_no;
        $salesOrder['branch_id'] = $request->debtor_no;
        $salesOrder['payment_id']= $request->payment_id;
        $salesOrder['person_id']= $userId;
        $salesOrder['reference'] ='COT-'. sprintf("%04d", $orderCount+1) .'/'. $parte_ano;
        $salesOrder['comments'] = $request->comments;
        $salesOrder['trans_type'] = SALESORDER;
        $salesOrder['invoice_type'] = 'indirectOrder';
        $salesOrder['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrder['from_stk_loc'] = $request->from_stk_loc;
        $salesOrder['total'] = $request->total;
        $salesOrder['created_at'] = date('Y-m-d H:i:s');
        $salesOrderId = DB::table('sales_orders')->insertGetId($salesOrder);
        // create salesOrder end
          if($orderReferenceNo>0){
        $orderReference = DB::table('sales_orders')->where('trans_type',SALESORDER)->select('reference')->orderBy('order_no','DESC')->first();
        $ref = explode("-",$orderReference->reference);
        $orderCount = (int) $ref[1];
        }else{
            $orderCount = 0 ;
        }


        // Create salesOrder Invoice start
        $salesOrderInvoice['order_reference_id'] = $salesOrderId;
        $salesOrderInvoice['order_reference'] = $salesOrder['reference'];
        $salesOrderInvoice['trans_type'] = SALESINVOICE;
        $salesOrderInvoice['invoice_type'] = 'directInvoice';
        $salesOrderInvoice['reference'] ='FT-'. sprintf("%04d", $orderCount+1) .'/'. $parte_ano;
        $salesOrderInvoice['debtor_no'] = $request->debtor_no;
        $salesOrderInvoice['branch_id'] = $request->debtor_no;
        $salesOrderInvoice['payment_id']= $request->payment_id;
        $salesOrderInvoice['person_id']= $userId;
        $salesOrderInvoice['comments'] = $request->comments;
        $salesOrderInvoice['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrderInvoice['from_stk_loc'] = $request->from_stk_loc;
        $salesOrderInvoice['total'] = $request->total;
        $salesOrderInvoice['payment_term'] = $request->payment_term;
        $salesOrderInvoice['created_at'] = date('Y-m-d H:i:s');
        $orderInvoiceId = DB::table('sales_orders')->insertGetId($salesOrderInvoice);
        // Create salesOrder Invoice end

        $facturaPronta =DB::table('sales_orders')
                ->where('invoice_type','=','directInvoice')
                ->orderBy('order_no','DESC')
                ->first();

            $ord_fact = $facturaPronta->order_no;
            $ref_fact = $facturaPronta->reference;
            $order_ref_fact = $facturaPronta->order_reference;
            $data_fact = $facturaPronta->ord_date;
            $entra="1";               
        
            //Inserting in sale CC 
            $salesCC['debtor_no_doc'] = $debtor;
            $salesCC['order_no_doc'] = $ord_fact;
            $salesCC['reference_doc'] = $ref_fact;
            $salesCC['order_reference_doc'] = $order_ref_fact;
            $salesCC['amount_doc'] = $grand_total;
            $salesCC['saldo_doc'] = $grand_total;
            $salesCC['ord_date_doc'] = $data_fact;
            //$salesCC['entra'] = $entra;         
            $salesCC['created_at'] = date('Y-m-d H:i:s');
            $salesCCId = DB::table('sales_cc')->insertGetId($salesCC);

    
            //order_ref_fact
            $salesPending['debtor_no_pending'] = $debtor;
            $salesPending['order_no_pending'] = $ord_fact;
            $salesPending['reference_pending'] = $ref_fact;
            $salesPending['amount_total_pending'] = $grand_total;         
            $salesPending['ord_date_pending'] = $data_fact;         
            $salesPending['created_at'] = date('Y-m-d H:i:s');
            $salesPendingId = DB::table('sales_pending')->insertGetId($salesPending);
            //end pending


        // Inventory Items Start
        if(!empty($description)){
            foreach ($description as $key => $item) {
            // Create salesOrderDetailInvoice Start
            $salesOrderDetailInvoice['order_no'] = $orderInvoiceId;
            $salesOrderDetailInvoice['description'] = $description[$key];
            $salesOrderDetailInvoice['quantity'] = $itemQuantity[$key];
            $salesOrderDetailInvoice['trans_type'] = SALESINVOICE;
            $salesOrderDetailInvoice['discount_percent'] = $itemDiscount[$key];
            $salesOrderDetailInvoice['tax_type_id'] = $taxIds[$key];
            $salesOrderDetailInvoice['tipo_operacao'] = "";
            $salesOrderDetailInvoice['cost_price'] = $preco_comp[$key];
            $salesOrderDetailInvoice['created_at'] = date('Y-m-d H:i:s');
            $salesOrderDetailInvoice['ord_date'] = DbDateFormat($request->ord_date);

            if($taxainclusa[$key]=='yes'){

                $ptUnitario=$unitPrice[$key] - ($unitPrice[$key]*($itemDiscount[$key]/100));
                $ptMontante= $itemPrice[$key]/$itemQuantity[$key];
                $taxa=(($ptUnitario/$ptMontante)-1)*100;

                $NovoPrecoUnitario=$unitPrice[$key]/(1+($taxa/100));
                $salesOrderDetailInvoice['unit_price'] = $NovoPrecoUnitario;
                $salesOrderDetailInvoice['taxa_inclusa_valor'] = 'yes';

                $priceAmount = ($itemQuantity[$key]*$NovoPrecoUnitario);
                 $discount = ($priceAmount*$itemDiscount[$key])/100;    
                 
            }else{
                  $salesOrderDetailInvoice['unit_price'] = $unitPrice[$key];
                   $salesOrderDetailInvoice['taxa_inclusa_valor'] = 'no';

                   $priceAmount = ($itemQuantity[$key]*$unitPrice[$key]);
                   $discount = ($priceAmount*$itemDiscount[$key])/100; 
            }

            $taxass = DB::table('item_tax_types')->where('id','=',$taxIds[$key])->first()->tax_rate;    
            $newPrice = ($priceAmount-$discount);
            $taxAmount = (($newPrice*$taxass)/100);
            $taxTotal += $taxAmount;
           
             //$stock_id[$key]!="zero"
             if($type[$key]==0){
                //$salesOrderDetailInvoice['stock_id'] = $stock_id[$key];
                $salesOrderDetailInvoice['is_inventory'] = 1; 
            }else{
                 $salesOrderDetailInvoice['is_inventory'] = 0;
            
            }

             $salesOrderDetailInvoice['stock_id'] = $stock_id[$key];
             DB::table('sales_order_details')->insertGetId($salesOrderDetailInvoice);
            // Create salesOrderDetailInvoice End
            

            //if($type[$key]==0){ $stock_id[$key]!="zero" || 
            if($type[$key]==0){
                // create stockMove 
                $stockMove['stock_id'] = $stock_id[$key];
                $stockMove['loc_code'] = $request->from_stk_loc;
                $stockMove['tran_date'] = DbDateFormat($request->ord_date);
                $stockMove['person_id'] = $userId;
                $stockMove['reference'] = 'store_out_'.$orderInvoiceId;
                $stockMove['transaction_reference_id'] =$orderInvoiceId;
                $stockMove['qty'] = '-'.$itemQuantity[$key];
                $stockMove['trans_type'] = SALESINVOICE;
                $stockMove['order_no'] = $salesOrderId;
                $stockMove['order_reference'] = $salesOrder['reference'];
                DB::table('stock_moves')->insertGetId($stockMove);
                }

            }
        }
        
        $Old['tax_total'] =$taxTotal;  
        DB::table('sales_orders')->where('order_no','=',$orderInvoiceId)->update($Old);

        DB::commit();


        if(!empty($orderInvoiceId)){
        \Session::flash('success',trans('message.success.save_success'));
         return redirect()->intended('invoice/view-detail-invoice/'.$salesOrderId.'/'.$orderInvoiceId);
        }

    }




    /**
     * Show the form for editing the specified resource.
     **/
    public function edit($orderNo)
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();
        $data['locData'] = DB::table('location')->get();
        $data['saleData'] = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();

 
       //return $data['invoiceData'] = $this->sale->OldgetSalseInvoiceByID($orderNo);

         $data['invoiceData'] = $this->sale->getSalseInvoiceByID($orderNo,$data['saleData']->from_stk_loc);

        $data['branchs'] = DB::table('cust_branch')->select('debtor_no','branch_code','br_name')->where('debtor_no',$data['saleData']->debtor_no)->orderBy('br_name','ASC')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['inoviceInfo'] = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get();
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();
       
        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
        $selectStart = "<select class='form-control taxList taxa' name='tax_id[]'>";
        $selectEnd = "</select>";
        $selectStartCustom = "<select class='form-control taxListCustom taxa' name='tax_id[]'>";
        $selectEndCustom = "</select>";   

        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";          
        }
        $data['tax_type_new'] = $selectStart.$taxOptions.$selectEnd;
        $data['tax_types'] = $taxTypeList;
        $data['tax_type_custom'] = $selectStartCustom.$taxOptions.$selectEndCustom;
        $data['tax_type'] = $selectStart.$taxOptions.$selectEnd;
        
        $dt = date("Y/m/d");
        $data['parte_ano'] =substr($dt,  0, 4);

       
        return view('admin.sale.sale_edit', $data);
    }
 


     /**
     * Update the specified resource in storage.
     **/
    public function update(Request $request)
    {
        $this->validate($request, [
            'from_stk_loc' => 'required',
            'ord_date' => 'required',
            'debtor_no' => 'required',
           'payment_id' => 'required',
        ]);

        $debtor = $request->debtor_no;
        $grand_total = $request->total;
        $order_no=$request->order_no;
        $reference=$request->reference;
        $userId = \Auth::user()->id;

        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $stock_id = $request->stock_id;
        $description = $request->description;
        $taxainclusa = $request->taxainclusa;
        $itemPrice = $request->item_price; 
        $preco_comp = $request->preco_comp; 
        $type = $request->type;
        $dt = date("Y/m/d");
        $parte_ano = substr($dt,  0, 4); 
    
    
        DB::beginTransaction();

        $salesOrderInvoice['debtor_no'] = $request->debtor_no;
        $salesOrderInvoice['branch_id'] = $request->debtor_no;
        $salesOrderInvoice['payment_id']= $request->payment_id;
        $salesOrderInvoice['person_id']= $userId;
        $salesOrderInvoice['comments'] = $request->comments;
        $salesOrderInvoice['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrderInvoice['from_stk_loc'] = $request->from_stk_loc;
        $salesOrderInvoice['total'] = $request->total;
        $salesOrderInvoice['payment_term'] = $request->payment_term;
        $salesOrderInvoice['created_at'] = date('Y-m-d H:i:s');
        DB::table('sales_orders')->where('order_no', $order_no)->update($salesOrderInvoice);

            // Create salesOrder Invoice end
            $facturaPronta =DB::table('sales_orders')
                ->where('order_no','=',$order_no)
               ->first();

            $ord_fact = $facturaPronta->order_no;
            $ref_fact = $facturaPronta->reference;
            $order_ref_fact = $facturaPronta->order_reference;
            $data_fact = $facturaPronta->ord_date;
            $cotacao = $facturaPronta->order_reference_id;
            $entra="1";               
        
            //Inserting in sale CC 
            $salesCC['debtor_no_doc'] = $debtor;
            $salesCC['order_no_doc'] = $ord_fact;
            $salesCC['reference_doc'] = $ref_fact;
            $salesCC['order_reference_doc'] = $order_ref_fact;
            $salesCC['amount_doc'] = $grand_total;
            $salesCC['saldo_doc'] = $grand_total;
            $salesCC['ord_date_doc'] = $data_fact;
            $salesCC['created_at'] = date('Y-m-d H:i:s');
            DB::table('sales_cc')->where('reference_doc', $ref_fact)->update($salesCC);
    
            //order_ref_fact
            $salesPending['debtor_no_pending'] = $debtor;
            $salesPending['order_no_pending'] = $ord_fact;
            $salesPending['reference_pending'] = $ref_fact;
            $salesPending['amount_total_pending'] = $grand_total;         
            $salesPending['ord_date_pending'] = $data_fact;         
            $salesPending['created_at'] = date('Y-m-d H:i:s');
            DB::table('sales_pending')->where('reference_pending', $ref_fact)->update($salesPending);

        //end pending
        DB::table('sales_order_details')->where('order_no','=',$order_no)->delete();   

        // Inventory Items Start
        if(!empty($description)){
            foreach ($description as $key => $item) {
            // Create salesOrderDetailInvoice Start
            $salesOrderDetailInvoice['order_no'] = $order_no;
            $salesOrderDetailInvoice['description'] = $description[$key];
            $salesOrderDetailInvoice['quantity'] = $itemQuantity[$key];
            $salesOrderDetailInvoice['trans_type'] = SALESINVOICE;
            $salesOrderDetailInvoice['discount_percent'] = $itemDiscount[$key];
            $salesOrderDetailInvoice['tax_type_id'] = $taxIds[$key];
            $salesOrderDetailInvoice['tipo_operacao'] = "";
            //$salesOrderDetailInvoice['cost_price'] = $preco_comp[$key];
            $salesOrderDetailInvoice['created_at'] = date('Y-m-d H:i:s');
            $salesOrderDetailInvoice['ord_date'] = DbDateFormat($request->ord_date);

            if($taxainclusa[$key]=='yes'){

                $ptUnitario=$unitPrice[$key] - ($unitPrice[$key]*($itemDiscount[$key]/100));
                $ptMontante= $itemPrice[$key]/$itemQuantity[$key];
                $taxa=(($ptUnitario/$ptMontante)-1)*100;

                $NovoPrecoUnitario=$unitPrice[$key]/(1+($taxa/100));
                $salesOrderDetailInvoice['unit_price'] = $NovoPrecoUnitario;
                $salesOrderDetailInvoice['taxa_inclusa_valor'] = 'yes'; 
            }else{
                  $salesOrderDetailInvoice['unit_price'] = $unitPrice[$key];
                  $salesOrderDetailInvoice['taxa_inclusa_valor'] = 'no';
            }
            
             if($type[$key]==0){
                 $salesOrderDetailInvoice['is_inventory'] = 1; 
            }else{
                 $salesOrderDetailInvoice['is_inventory'] = 0;
            
            }
            
           $salesOrderDetailInvoice['stock_id'] = $stock_id[$key];
           DB::table('sales_order_details')->insertGetId($salesOrderDetailInvoice);
           // Create salesOrderDetailInvoice End

          DB::table('stock_moves')->where('reference','=','store_out_'.$order_no)->delete();   
            //if($type[$key]==0){
            //$stock_id[$key]!="zero" || 

            if($type[$key]==0){
                $stockMove['stock_id'] = $stock_id[$key];
                $stockMove['loc_code'] = $request->from_stk_loc;
                $stockMove['tran_date'] = DbDateFormat($request->ord_date);
                $stockMove['person_id'] = $userId;
                $stockMove['reference'] = 'store_out_'.$order_no;
                $stockMove['transaction_reference_id'] =$order_no;
                $stockMove['qty'] = '-'.$itemQuantity[$key];
                $stockMove['trans_type'] = SALESINVOICE;
                $stockMove['order_no'] = $cotacao;
                //$stockMove['order_reference'] = $salesOrderInvoice['order_reference'];
                DB::table('stock_moves')->insertGetId($stockMove);
                }

            }
        }
     
     
     DB::commit();

        \Session::flash('success',trans('message.success.save_success'));
         return redirect()->intended('invoice/view-detail-invoice/'.$cotacao.'/'.$order_no);  
   
   }





    /**
     * Update the specified resource in storage.
     **/
    public function updateOld(Request $request)
    {

        $userId = \Auth::user()->id;
        $order_no = $request->order_no;
        $order_ref_no = $request->order_reference_id;
        $this->validate($request, [
            //'reference'=>'required|unique:sales_orders,reference,'.$order_no.',order_no',
            'from_stk_loc' => 'required',
            'ord_date' => 'required',
            'debtor_no' => 'required',
            'payment_id' => 'required'
        ]);
        //d($request->all(),1);
        $stockId = $request->stock_id;
        $itemQty = $request->item_quantity;
        $unitPrice = $request->unit_price;
        $taxIds = $request->tax_id;                
        $itemDiscount = $request->discount;
        $itemPrice = $request->item_price; 
        $description = $request->description;

        $itemRowIds = $request->item_rowid;
        // update sales_order table

        $salesOrder['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrder['payment_term'] = $request->payment_term;
        $salesOrder['from_stk_loc'] = $request->from_stk_loc;
        $salesOrder['debtor_no'] = $request->debtor_no;
        $salesOrder['comments'] = $request->comments;
        $salesOrder['total'] = $request->total;
        $salesOrder['updated_at'] = date('Y-m-d H:i:s');
         DB::table('sales_orders')->where('order_no', $order_no)->update($salesOrder);
        if(count($itemRowIds)>0) {

            $orderItemRowIds = DB::table('sales_order_details')->where('order_no',$order_no)->lists('id');
                // Delete items from order if no exists on updated orders
                foreach ($orderItemRowIds as $key=>$orderItemRowId) {
                  if(!in_array($orderItemRowId, $itemRowIds)){
                   
                    $stock = DB::table('sales_order_details')->where('id',$orderItemRowId)->first();
                    DB::table('sales_order_details')->where(array('id'=>$orderItemRowId,'order_no'=>$order_no))->delete();
                    if(!empty($stock->stock_id)){
                    DB::table('stock_moves')
                    ->where(array('reference'=>'store_out_'.$order_no,'stock_id'=>$stock->stock_id))->delete();
                   }
                  }
                }

                foreach ($itemRowIds as $key => $value) {
                        // update sales_order_details table
                        $salesOrderDetail['description'] = $description[$key];
                        $salesOrderDetail['tax_type_id'] = $taxIds[$key];
                        $salesOrderDetail['unit_price'] = $unitPrice[$key];
                        $salesOrderDetail['quantity'] = $itemQty[$key];
                        $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
                        DB::table('sales_order_details')->where(['id'=>$value])->update($salesOrderDetail);
                        // Update stock_move table
                      if($stockId[$key]){
                        $stockMove['qty'] = '-'.$itemQty[$key];
                        DB::table('stock_moves')->where(['stock_id'=>$stockId[$key],'reference'=>'store_out_'.$order_no])->update($stockMove);
                      }
                }
        }

        if(isset($request->description_new)) 
        {
            $itemQtyNew = $request->item_quantity_new;
            $itemIdsNew = $request->item_id_new; 
            $unitPriceNew = $request->unit_price_new;
            $taxIdsNew = $request->tax_id_new;                
            $itemDiscountNew = $request->discount_new;
            $itemPriceNew = $request->item_price_new; 
            $descriptionNew = $request->description_new;
            $stockIdNew = $request->stock_id_new; 
            
            foreach ($descriptionNew as $key => $value) {
            // Insert new sales order detail
            $salesOrderDetailNew['trans_type'] = SALESORDER;
            $salesOrderDetailNew['order_no'] = $order_no;
            $salesOrderDetailNew['stock_id'] = $stockIdNew[$key];
            $salesOrderDetailNew['description'] = $descriptionNew[$key];
            $salesOrderDetailNew['quantity'] = $itemQtyNew[$key];
            $salesOrderDetailNew['discount_percent'] = $itemDiscountNew[$key];
            $salesOrderDetailNew['tax_type_id'] = $taxIdsNew[$key];
            $salesOrderDetailNew['unit_price'] = $itemPriceNew[$key];
            $salesOrderDetailNew['is_inventory'] = 1;
            DB::table('sales_order_details')->insertGetId($salesOrderDetailNew);

            $stockMove['stock_id'] = $stockIdNew[$key];
            $stockMove['order_no'] = $request->order_reference_id;
            $stockMove['trans_type'] = 202;
            $stockMove['loc_code'] = $request->from_stk_loc;
            $stockMove['person_id'] = $userId;
            $stockMove['tran_date'] =date('Y-m-d');
            $stockMove['order_reference'] = $request->reference;
            $stockMove['reference'] = 'store_out_'.$order_no;
            $stockMove['transaction_reference_id'] = $order_no;
            $stockMove['qty'] = '-'.$itemQtyNew[$key];
            DB::table('stock_moves')->insert($stockMove);

            }
          
        }

        // Custom items Start
        $tax_id_custom = $request->tax_id_custom;
        $custom_items_discount = $request->custom_items_discount_new;
        $custom_items_name = $request->custom_items_name_new;
        $custom_items_rate = $request->custom_items_rate_new;
        $custom_items_qty  = $request->custom_items_qty_new;
        $custom_items_amount = $request->custom_items_amount_new;
        if(!empty($custom_items_name)){
            foreach ($custom_items_name as $key=>$value) {
               $items['order_no'] = $order_no;
               $items['trans_type'] = SALESINVOICE;
               $items['tax_type_id'] = $tax_id_custom[$key];
               $items['discount_percent'] = $custom_items_discount[$key];
               $items['description'] = $custom_items_name[$key];
               $items['unit_price'] = $custom_items_rate[$key];
               $items['quantity'] = $custom_items_qty[$key];
               $items['is_inventory'] = 0;
               DB::table('sales_order_details')->insert($items);              
            }
       }


        \Session::flash('success',trans('message.success.save_success'));
         return redirect()->intended('invoice/view-detail-invoice/'.$order_ref_no.'/'.$order_no);
    }







    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if(isset($id)) {
        return    $record = \DB::table('sales_orders')->where('order_no', $id)->first();
            if($record) {
                
                DB::table('sales_orders')->where('order_no', '=', $record->order_no)->delete();
                DB::table('sales_order_details')->where('order_no', '=', $record->order_no)->delete();
                DB::table('stock_moves')->where('reference', '=', 'store_out_'.$record->order_no)->delete();
                DB::table('sales_cc')->where('reference_doc', '=', $record->order_no)->delete();

                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('sales/list');
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
                    $desconto=$itemPriceValue->discounto;

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
                    $return_arr[$i]['desconto'] = $desconto;
                    $return_arr[$i]['preco_compra'] =$value->preco_compra;
                    $return_arr[$i]['servico']=$value->item_type_id;
                    $i++;
                }
               //echo json_encode($return_arr);
               
                 $data['items'] = $return_arr;
            }
            echo json_encode($data);
            exit;  

    }

    public function checkItemQty(Request $request)
    {
       $data = array();
        $location = $request['loc_code'];
        $stock_id = $request['stock_id'];
        $itemQty = $this->sale->stockValidate($location,$stock_id);
        
        if($itemQty <= 0){
            $data['status_no'] = 1; 
        }

        return json_encode($data);        

    }
    /**
    * Return quantity validation result
    */
    public function quantityValidation(Request $request){
        $data = array();
        $location = $request['location_id'];
        $setItem = $request['qty'];

        $item_code = DB::table('item_code')->where("id",$request['id'])->select('stock_id')->first();
        
        $availableItem = $this->sale->stockValidate($location,$item_code->stock_id);

        $data['availableItem'] = $availableItem;
        $data['message'] = trans('message.table.tax').$availableItem;

        return json_encode($data);
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

    public function quantityValidationWithLocaltion(Request $request){
        $location = $request['location'];
        $items    = $request['itemInfo'];
        $data['status_no'] = 0;
        $data['item']      = trans('message.invoice.item_insufficient_message');
        //d($items,1);
        foreach($items as $result){
        $qty = DB::table('stock_moves')
                     ->select(DB::raw('sum(qty) as total'))
                     ->where(['stock_id'=>$result['stockid'], 'loc_code'=>$location])
                     ->groupBy('loc_code')
                     ->first();
        if(empty($qty)){
            return json_encode($data);
        }else if($qty<$result['qty']){
            return json_encode($data);
        }else{
            $datas['status_no'] = 1;
            return json_encode($datas);
          }
       }
    }

    public function quantityValidationEditInvoice(Request $request){
        
        $location = $request['location_id'];
        $item_id = $request['item_id'];
        $stock_id = $request['stock_id'];
        $set_qty = $request['qty'];
        $invoice_order_no = $request['invoice_no'];
        $order_reference = $request['order_reference'];
        $order = DB::table('sales_orders')->where('reference',$request['order_reference'])->select('order_no')->first();
        $orderItemQty = DB::table('sales_order_details')
                        ->where(['order_no'=>$order->order_no,'stock_id'=>$stock_id])
                        ->select('quantity')
                        ->first();
       
        $salesItemQty = DB::table('stock_moves')
                        ->where(['order_reference'=>$order_reference,'stock_id'=>$stock_id,'loc_code'=>$location])
                        ->where('reference','!=','store_out_'.$invoice_order_no)
                        ->sum('qty');

        $itemAvailable = $orderItemQty->quantity + ($salesItemQty);

       if($set_qty>$itemAvailable){
            $data['status_no'] = 0;
            $data['qty']       ="qty Insufficient";
       }else{
        $data['status_no'] = 1;
        $data['qty']       ="qty available";
       }
       return json_encode($data);
    }




        //Funcao para actualizar os estado da factura
        public function editStatus($id,Request $request){
         

        $factura=$request->orderInvoiceId+1;       
        $dados=Sales::where("order_no","=",$factura)->first();
        $reference=$dados->reference;

         //actualizando a tabela da factura   
         $order = Sales::where('order_no',$id )->update(['status' =>'cancelado','description' => $request->description]);
          //actualizando a tabela da factura no CC   
        DB::table('sales_cc')->where('reference_doc', $reference)->update(['status' => 'cancelado']);
          
        DB::table('sales_pending')->where('debtor_no_pending', $id)->update(['status' => 'cancelado']);  

        $UpdateStock=SockMove::where("order_no","=",$request->orderInvoiceId)->get();
      

            if($UpdateStock!=null){
           
                foreach ($UpdateStock as $UpdateStocks) {
                  if($UpdateStocks->stock_id!='zero'){
                        DB::table('stock_moves')
                        ->where('order_no', $request->orderInvoiceId)
                        ->update(['qty' => 0]);
                    }

                }
             } 
       
            $invoice=$request->orderInvoiceId+1;

        \Session::flash('success',trans('message.success.save_success'));
         return redirect()->intended('invoice/view-detail-invoice/'.$request->orderInvoiceId.'/'.$invoice);
        

    }
    


    public function report()
    {
        $data['salesData'] = $this->sale->getAllSalseOrder($from = NULL, $to = NULL, $item = NULL, $customer = NULL, $location = NULL);
        $pdf = PDF::loadView('admin.sale.report.salesReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Recibos'.time().'.pdf',array("Attachment"=>0));
    }

     public function getDetalhes(Request $request){

      $order = $request->order;

     return $orderDetalhes = DB::table('sales_order_details')->where('order_no','=',$order)->select('sales_order_details.*')->get();

      }

      // repor
       public function reporte(){
       
        $data['salesData'] = $this->sale->getAllSalseOrder($from = NULL, $to = NULL, $item = NULL, $customer = NULL, $location = NULL);
        $pdf = PDF::loadView('admin.salesOrder.reports.saleReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Factura'.time().'.pdf',array("Attachment"=>0));
    }

    // 
     public function customer_info(Request $request){
    
        $debtor_no = $request['debtor_no'];
        $Ponto_situcao=DB::table('cust_branch')->where('debtor_no', $debtor_no)->select('imposto', 'discounto','motivation')->first();
        return json_encode($Ponto_situcao);
    


    } 



}
