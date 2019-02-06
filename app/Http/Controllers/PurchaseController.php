<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Purchase;
use App\Http\Requests;
use DB;
use PDF;
use Auth;
use App\Http\Start\Helpers;




class PurchaseController extends Controller
{ 
    public function __construct(Auth $auth) {
     /**
     * Set the database connection. reference app\helper.php
     */  
     $this->middleware('auth');
     $this->auth = $auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_compra_for';
        $data['purchData'] = (new Purchase)->getAllPurchOrder();
        return view('admin.purchase.purch_list', $data);
    }

    

    public function vd()
    {
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_vd_for';
        $data['purchVDData']=DB::table('purchase_vd')
                            ->leftjoin('suppliers','suppliers.supplier_id','=','purchase_vd.supplier_no_vd')
                            ->select('purchase_vd.*', 'suppliers.supp_name','suppliers.nuit')
                            ->orderBy('purchase_vd.vd_date', 'desc')
                            ->get();
        return view('admin.purchase.purch_vd', $data);
    }

    public function createVD(){
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_vd_for';

        $data['suppData'] = DB::table('suppliers')->where(['inactive'=>0])->get();
        $data['locData'] = DB::table('location')->get();
        $data['order'] = DB::table('purch_orders')->select('order_no')->orderBy('order_no', 'desc')->limit(1)->first();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();
        $data['accounts'] = DB::table('bank_accounts')->where(['deleted'=>0])->pluck('account_name','id');
        $order_count = DB::table('purchase_vd')->count();

        if($order_count>0){
        $orderReference = DB::table('purchase_vd')->select('reference_vd')->orderBy('vd_no','DESC')->first();

        $ref = explode("-",$orderReference->reference_vd);
        $data['order_count'] = (int) $ref[1];
        }else{
            $data['order_count'] = 0 ;
        }

        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
        $selectStart = "<select class='form-control taxList' name='tax_id[]'>";
        $selectEnd = "</select>";
        
        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";          
        }
        $data['tax_type'] = $selectStart.$taxOptions.$selectEnd;

        return view('admin.purchase.purch_add_vd', $data);
    }

     public function storeVD(Request $request)
    {
       // return $request->all();
        $user_id = \Auth::user()->id;
        $this->validate($request, [
            'reference'=>'required|unique:purch_orders',
            'ord_date' => 'required',
            'supplier_id' => 'required',
            'item_quantity' => 'required',
            'payment_id' => 'required',
            'account_no' => 'required',
            'into_stock_location' => 'required',
        ]);

        require_once './conexao.php';

        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $stock_id = $request->stock_id;
        $description = $request->description;

        $supplier_no = $_POST["supplier_id"];
        $data_vd = $_POST["ord_date"];
        $ref_vd = $_POST["reference"];
        $payment_id = $_POST["payment_id"];
        $account_no = $_POST["account_no"];
        $comments = $_POST["comments"];
        $total = $_POST["total"]; 
        $into_stock_location=$_POST["into_stock_location"]; 

        $data1 = substr($data_vd, 0, 2);
        $data2 = substr($data_vd, 3, 2);
        $data3 = substr($data_vd, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }
      
            //$purchVD['vd_no'] = $last_id;
            $purchVD['supplier_no_vd'] = $supplier_no;
            $purchVD['account_no'] = $account_no;
            $purchVD['reference_vd'] = $ref_vd;
            $purchVD['vd_date'] = $data_final;
            $purchVD['payment_id'] = $payment_id;
            $purchVD['total'] =$total;
            $purchVD['into_stock_location'] =$into_stock_location;
            $purchVD['comments'] =$comments;
            $last_id = DB::table('purchase_vd')->insertGetId($purchVD);

        
             if(!empty($description)){
                foreach ($description as $key => $item) {

                    $purchVDDetail['vd_no'] = $last_id;
                    $purchVDDetail['stock_id'] = $stock_id[$key];
                    $purchVDDetail['description'] = $item;
                    $purchVDDetail['quantity'] = $itemQuantity[$key];
                    $purchVDDetail['tax_type_id'] = $taxIds[$key];
                    $purchVDDetail['unit_price'] = $unitPrice[$key];
                    $purchVDDetail['discount_percent'] =$itemDiscount[$key];
                    $purchVDDetail['is_inventory'] =1;
                    DB::table('purchase_vd_details')->insertGetId($purchVDDetail);
                    //$salesOrderDetail['is_inventory'] = 1;
                   
                    // stockMove information
                    $stockMove['stock_id'] = $stock_id[$key];
                    $stockMove['trans_type'] =PURCHINVOICE;
                    $stockMove['loc_code'] = $request->into_stock_location;
                    $stockMove['tran_date'] = DbDateFormat($request->ord_date);
                    $stockMove['person_id'] = $user_id;
                    $stockMove['reference'] = 'store_in_'.$last_id;
                    $stockMove['transaction_reference_id'] =$last_id;
                    $stockMove['qty'] =$itemQuantity[$key];
                    $stockMove['price'] = $unitPrice[$key];
                    // End stockMove information
                    DB::table('stock_moves')->insertGetId($stockMove);

                        $purchaseDataInfo = DB::table('purchase_prices')->where('stock_id',$stock_id[$key])->count(); 
                        //d($purchaseDataInfo,1);
                        if($purchaseDataInfo == false){
                        $purchaseData['supplier_id'] = $request->supplier_id;
                        $purchaseData['stock_id'] = $stock_id[$key];
                        $purchaseData['price'] = $itemPrice[$key];
                        DB::table('purchase_prices')->insert($purchaseData);
                    }


                }    
             }
                
              //cc
                $entra = '0';
                $payment3['supp_id_doc'] = $request->supplier_id;
                $payment3['order_no_doc'] = $last_id;
                $payment3['reference_doc'] = $request->reference;
                $payment3['amount_doc'] =  $request->total;
                $payment3['debito_credito'] =  $entra; 
                $payment3['ord_date_doc'] = DbDateFormat($request->ord_date);
                $payment3 = DB::table('purch_cc')->insertGetId($payment3);
                //end cc
        
         //edit saldo conta:
        $query_account = "Select sum(amount) from bank_trans where account_no = '$account_no'";
        $comando_account = $pdo->prepare($query_account);
        if($comando_account->execute()){
            $rs_account = $comando_account->fetch();
            $balance = $rs_account ["sum(amount)"];
            $new_balance = $balance - $total;
            $new_negative_balance = "-".$total;

            // Transaction Table
            $data['account_no'] = $request->account_no;//
            $data['trans_date'] = DbDateFormat($request->ord_date);//
            $data['description'] = "Supplier Payment";//
            $data['amount'] = $new_negative_balance;//
            $data['category_id'] = '1';
            $data['person_id'] = $this->auth->id;
            $data['trans_type'] = 'cash-in-by-sale';//
            $data['payment_method'] = $request->payment_id;
            $data['created_at'] = date("Y-m-d H:i:s");//
            $transactionId = DB::table('bank_trans')->insertGetId($data);
        }
        
        if(!empty($last_id)){
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('purchase/view-detail-vd/'.$last_id);
        }
    }



public function viewVDDetails($vdId){
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_vd_for';

        $data['saleDataOrder'] = DB::table('purchase_vd')
                            ->where('vd_no', '=', $vdId)
                            ->select("purchase_vd.*")
                            ->first();
        //$data['invoiceType'] = $data['saleDataOrder']->invoice_type;

        $data['saleDataInvoice'] = DB::table('purchase_vd')
                    ->where('vd_no', '=', $vdId)
                    ->select("purchase_vd.*")
                    ->first(); 
     $data['invoiceData'] = DB::table('purchase_vd')

        ->leftJoin('purchase_vd_details','purchase_vd_details.vd_no','=','purchase_vd.vd_no')
        ->where('purchase_vd.vd_no', '=', $vdId)
                    ->select("purchase_vd.*", "purchase_vd_details.*")
                    ->get();
       

        $data['orderInfo']  = DB::table('purchase_vd')->where('vd_no',$vdId)->select('reference_vd','vd_no')->first();

        $data['payments']   = DB::table('payment_terms')->get();
        

        //$data['invoice_no'] = $invoiceNo;
        
        $data['invoiced_status'] = 'yes';
        //$data['invoiced_date'] = $data['saleDataInvoice']->ord_date;

       
        
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
        
        return view('admin.purchase.purchaseVDDetails', $data);
    }



    public function vdPdf($vdId){

        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_vd_for';



       $data['saleDataOrder'] = DB::table('purchase_vd')
                            ->where('vd_no', '=', $vdId)
                            ->select("purchase_vd.*")
                            ->first();
        //$data['invoiceType'] = $data['saleDataOrder']->invoice_type;

        $data['saleDataInvoice'] = DB::table('purchase_vd')
                    ->where('vd_no', '=', $vdId)
                    ->select("purchase_vd.*")
                    ->first(); 

        $data['invoiceData'] = DB::table('purchase_vd')
        ->leftJoin('purchase_vd_details','purchase_vd_details.vd_no','=','purchase_vd.vd_no')
        ->where('purchase_vd.vd_no', '=', $vdId)
                    ->select("purchase_vd.*", "purchase_vd_details.*")
                    ->get();
       
       $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');
        

        $data['orderInfo']  = DB::table('purchase_vd')->where('vd_no',$vdId)->select('reference_vd','vd_no')->first();

        $data['payments']   = DB::table('payment_terms')->get();

        $pdf = PDF::loadView('admin.purchase.purch_pdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('vd_supp_'.time().'.pdf',array("Attachment"=>0));
    }

    public function vdPrint($vdId){
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_vd_for';



       $data['saleDataOrder'] = DB::table('purchase_vd')
                            ->where('vd_no', '=', $vdId)
                            ->select("purchase_vd.*")
                            ->first();
        //$data['invoiceType'] = $data['saleDataOrder']->invoice_type;

        $data['saleDataInvoice'] = DB::table('purchase_vd')
                    ->where('vd_no', '=', $vdId)
                    ->select("purchase_vd.*")
                    ->first(); 

        $data['invoiceData'] = DB::table('purchase_vd')
        ->leftJoin('purchase_vd_details','purchase_vd_details.vd_no','=','purchase_vd.vd_no')
        ->where('purchase_vd.vd_no', '=', $vdId)
                    ->select("purchase_vd.*", "purchase_vd_details.*")
                    ->get();
       
       $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');
        

        $data['orderInfo']  = DB::table('purchase_vd')->where('vd_no',$vdId)->select('reference_vd','vd_no')->first();

        $data['payments']   = DB::table('payment_terms')->get();


        $pdf = PDF::loadView('admin.purchase.supplier-vdPDFPrint', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('vd_supp_'.time().'.pdf',array("Attachment"=>0));        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_compra_for';
        $data['suppData'] = DB::table('suppliers')->where(['inactive'=>0])->get();
        $data['locData'] = DB::table('location')->get();
        $data['order'] = DB::table('purch_orders')->select('order_no')->orderBy('order_no', 'desc')->limit(1)->first();
        $order_count = DB::table('purch_orders')->count();

        if($order_count>0){
        $orderReference = DB::table('purch_orders')->select('reference')->orderBy('order_no','DESC')->first();

        $ref = explode("-",$orderReference->reference);
        $data['order_count'] = (int) $ref[1];
        }else{
            $data['order_count'] = 0 ;
        }

        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
        $selectStart = "<select class='form-control taxList' name='tax_id[]'>";
        $selectEnd = "</select>";
        $selectStartCustom = "<select class='form-control taxListCustom' name='tax_id[]'>";
        $selectEndCustom = "</select>";
        
        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";          
        }
        $data['tax_type'] = $selectStart.$taxOptions.$selectEnd;
         $data['tax_type_custom'] = $selectStartCustom.$taxOptions.$selectEndCustom;
      
        return view('admin.purchase.purch_add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->All();
        $user_id = \Auth::user()->id;

        $this->validate($request, [
            'reference'=>'required|unique:purch_orders',
            'into_stock_location' => 'required',
            'ord_date' => 'required',
            'supplier_id' => 'required',
            'item_quantity' => 'required',
        ]);


        $itemQty = $request->item_quantity;        
        $itemIds = $request->item_id;
        $taxIds = $request->tax_id;
        $itemPrice = $request->item_price;
        $stock_id = $request->stock_id;
        $description = $request->description;
        $unitPrice = $request->unit_price; 
        $discount_percent=$request->discount;
        
        foreach ($itemQty as $key => $value) {
            $product[$itemIds[$key]] = $value;
        }


        $orderReferenceNo = DB::table('purch_orders')->count();
        $data['ord_date'] = DbDateFormat($request->ord_date);
        $data['supplier_id'] = $request->supplier_id;
        $data['person_id'] = $user_id;
        $data['reference'] = 'OC-'. sprintf("%04d", $orderReferenceNo+1);
        $data['total'] = $request->total;
        $data['into_stock_location'] = $request->into_stock_location;
        $data['comments'] = $request->comments;
        //$data['created_at'] = date('Y-m-d H:i:s');
        $order_id = DB::table('purch_orders')->insertGetId($data);

        for ($i=0; $i < count($itemIds); $i++) {
            foreach ($product as $key => $value) {
                if($itemIds[$i] == $key){
                    // purchOrderdetail information
                    $purchOrderdetail[$i]['order_no'] = $order_id;
                    $purchOrderdetail[$i]['item_code'] = $stock_id[$i];
                    $purchOrderdetail[$i]['description'] = $description[$i];
                    $purchOrderdetail[$i]['quantity_ordered'] = $value;
                    $purchOrderdetail[$i]['quantity_received'] = $value;
                    $purchOrderdetail[$i]['qty_invoiced'] = $value;
                    $purchOrderdetail[$i]['unit_price'] = $unitPrice[$i];
                    $purchOrderdetail[$i]['tax_type_id'] = $taxIds[$i];
                    $purchOrderdetail[$i]['discount_percent'] = $discount_percent[$i];
                     // stockMove information
                    $stockMove[$i]['stock_id'] = $stock_id[$i];
                    $stockMove[$i]['trans_type'] = PURCHINVOICE;
                    $stockMove[$i]['loc_code'] = $request->into_stock_location;
                    $stockMove[$i]['tran_date'] = DbDateFormat($request->ord_date);
                    $stockMove[$i]['person_id'] = $user_id;
                    $stockMove[$i]['reference'] = 'store_in_'.$order_id;
                    $stockMove[$i]['transaction_reference_id'] =$order_id;
                    $stockMove[$i]['qty'] = $value;
                    $stockMove[$i]['price'] = $unitPrice[$i];
                }

                  $purchaseDataInfo = DB::table('purchase_prices')->where('stock_id',$stock_id[$i])->count(); 
               
                //d($purchaseDataInfo,1);
                if($purchaseDataInfo == false){
                    $purchaseData['supplier_id'] = $request->supplier_id;
                    $purchaseData['stock_id'] = $stock_id[$i];
                    $purchaseData['price'] = $itemPrice[$i];
                    DB::table('purchase_prices')->insert($purchaseData);
                }

            }
        }

        for ($i=0; $i < count($purchOrderdetail); $i++) {
            DB::table('purch_order_details')->insertGetId($purchOrderdetail[$i]);
            DB::table('stock_moves')->insertGetId($stockMove[$i]);
        }

         //cc
                $entra = '0';
                $payment3['supp_id_doc'] = $request->supplier_id;
                $payment3['order_no_doc'] = $order_id;
                $payment3['reference_doc'] = 'OC-'. sprintf("%04d", $orderReferenceNo+1);
                $payment3['amount_doc'] =  $request->total;
                $payment3['debito_credito'] =  $entra; 
                $payment3['ord_date_doc'] = DbDateFormat($request->ord_date);
                $payment3 = DB::table('purch_cc')->insertGetId($payment3);
                //end cc

        if (!empty($order_id)) {
            \Session::flash('success',trans('message.success.save_success'));
             return redirect()->intended('purchase/view-purchase-details/'.$order_id);
           // return redirect()->intended('purchase/list');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['menu'] = 'purchase';
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['supplierData'] = DB::table('suppliers')->get();
        $data['locData'] = DB::table('location')->get();
        $data['invoiceData'] = (new Purchase)->getPurchaseInvoiceByID($id);
        $data['purchData'] = DB::table('purch_orders')->where('order_no', '=', $id)->first();
        
        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
        $selectStart = "<select class='form-control taxList' name='tax_id_new[]'>";
        $selectEnd = "</select>";
        
        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";          
        }
        $data['tax_type_new'] = $selectStart.$taxOptions.$selectEnd;
        $data['tax_types'] = $taxTypeList;

        return view('admin.purchase.purch_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user_id = \Auth::user()->id;
        $this->validate($request, [
            'into_stock_location' => 'required',
            'ord_date' => 'required',
            //'supplier_id' => 'required',
        ]);

       // d($request->all());
        $order_id = $request->order_no;        
        $data['ord_date'] = DbDateFormat($request->ord_date);
        //$data['supplier_id'] = $request->supplier_id;
        //$data['reference'] = $request->reference;
        $data['into_stock_location'] = $request->into_stock_location;
        $data['comments'] = $request->comments;
        $data['total'] = $request->total;
        //$data['updated_at'] = date('Y-m-d H:i:s');

        /*CALCULANDO VALOR PAGO:*/
        $dados = DB::table('purch_orders')->where('order_no', '=', $order_id)->first();
        $dados->saldo;
        $dados->valor_pago;
        $data ['valor_pago'] = $request->valor_a_pagar + $dados->valor_pago;
        $data ['saldo'] = $dados->total - ($request->valor_a_pagar + $dados->valor_pago); 

        DB::table('purch_orders')->where('order_no', $order_id)->update($data);

        if(isset($request->item_quantity)) {
            
            $itemQty = $request->item_quantity;        
            $itemIds = $request->item_id;
            $taxIds = $request->tax_id;
            $itemPrice = $request->item_price;
            $stock_id = $request->stock_id;
            $description = $request->description;
            $unitPrice = $request->unit_price; 
            $discount_percent=$request->discount;           

            $invoiceData = (new Purchase)->getPurchaseInvoiceByID($order_id);
            $invoiceData = objectToArray($invoiceData);

            for ($i=0;$i<count($invoiceData);$i++) {
                
                if (!in_array($invoiceData[$i]['item_id'],$itemIds)) {
                    DB::table('purch_order_details')->where([['order_no','=',$invoiceData[$i]['order_no']],['item_code','=',$invoiceData[$i]['item_code']],])->delete();
                    DB::table('stock_moves')->where([['stock_id','=',$invoiceData[$i]['item_code']],['reference','=','store_in_'.$order_id],])->delete();
                }
            }

            foreach ($itemQty as $key => $value) {
                
                $product[$itemIds[$key]] = $value;

            }

            for ($i=0; $i < count($itemIds); $i++) {
                foreach ($product as $key => $value) {
                    if($itemIds[$i] == $key){
                        // Order Details
                        $purchaseOrderDetails[$i]['item_code'] = $stock_id[$i];
                        $purchaseOrderDetails[$i]['description'] = $stock_id[$i];
                        $purchaseOrderDetails[$i]['quantity_ordered'] = $value;
                        $purchaseOrderDetails[$i]['quantity_received'] = $value;
                        $purchaseOrderDetails[$i]['qty_invoiced'] = $value;
                        $purchaseOrderDetails[$i]['unit_price'] = $unitPrice[$i];
                        $purchOrderdetail[$i]['discount_percent'] = $discount_percent[$i];
                        //End Order Details
                        //Start Stock Move
                        $stockMove[$i]['stock_id'] = $stock_id[$i];
                        $stockMove[$i]['trans_type'] = PURCHINVOICE;
                        $stockMove[$i]['loc_code'] = $request->into_stock_location;
                        $stockMove[$i]['tran_date'] = DbDateFormat($request->ord_date);
                        $stockMove[$i]['person_id'] = $user_id;
                        $stockMove[$i]['reference'] = 'store_in_'.$order_id;
                        $stockMove[$i]['transaction_reference_id'] = $order_id;
                        $stockMove[$i]['qty'] = $value;
                        $stockMove[$i]['price'] = $itemPrice[$i];
                        //End Stock Move
                    }
                }
            }

            for ($i=0; $i < count($purchaseOrderDetails); $i++) {
                DB::table('purch_order_details')->where([['item_code','=',$purchaseOrderDetails[$i]['item_code']],['order_no','=',$order_id],])->update($purchaseOrderDetails[$i]);
                DB::table('stock_moves')->where([['stock_id','=',$stockMove[$i]['stock_id']],['reference','=','store_in_'.$order_id],])->update($stockMove[$i]);
            }
        } else {
            $invoiceData = (new Purchase)->getPurchInvoiceByID($order_id);
            $invoiceData = objectToArray($invoiceData);
            for ($i=0;$i<count($invoiceData);$i++) {
                DB::table('purch_order_details')->where([['order_no','=',$invoiceData[$i]['order_no']],['item_code','=',$invoiceData[$i]['item_code']],])->delete();
                DB::table('stock_moves')->where([['stock_id','=',$invoiceData[$i]['item_code']],['reference','=','store_in_'.$order_id],])->delete(); 
            }
        }

        if(isset($request->item_quantity_new)) 
        {
            $item_quantity_new = $request->item_quantity_new;        
            $ids_new = $request->item_id_new;
            $taxIds_new = $request->tax_id_new;
            $itemPrice_new = $request->item_price_new;
            $unitPrice_new = $request->unit_price_new;
            $stock_id_new = $request->stock_id_new;
            $description_new = $request->description_new;
            
            foreach ($item_quantity_new as $key => $value) {
                $product_new[$ids_new[$key]] = $value;

            }
            

            for ($i=0; $i < count($ids_new); $i++) {
                foreach ($product_new as $key => $value) {
                    if ($ids_new[$i]== $key) {
                        // Order
                        $purchOrderdetailNew[$i]['order_no'] = $order_id;
                        $purchOrderdetailNew[$i]['item_code'] = $stock_id_new[$i];
                        $purchOrderdetailNew[$i]['description'] = $description_new[$i];
                        $purchOrderdetailNew[$i]['quantity_ordered'] = $value;
                        $purchOrderdetailNew[$i]['quantity_received'] = $value;
                        $purchOrderdetailNew[$i]['qty_invoiced'] = $value;
                        $purchOrderdetailNew[$i]['unit_price'] = $itemPrice_new[$i];
                        $purchOrderdetailNew[$i]['tax_type_id'] = $taxIds_new[$i];
                        $purchOrderdetailNew[$i]['unit_price'] = $unitPrice_new[$i];
                        $purchOrderdetail[$i]['discount_percent'] = $discount_percent[$i];
                       
                        // Order Details
                        $stockMoveNew[$i]['stock_id'] = $stock_id_new[$i];
                        $stockMoveNew[$i]['trans_type'] = PURCHINVOICE;
                        $stockMoveNew[$i]['loc_code'] = $request->into_stock_location;
                        $stockMoveNew[$i]['tran_date'] = DbDateFormat($request->ord_date);
                        $stockMoveNew[$i]['person_id'] = $user_id;
                        $stockMoveNew[$i]['reference'] = 'store_in_'.$order_id;
                        $stockMoveNew[$i]['transaction_reference_id'] =$order_id;
                        $stockMoveNew[$i]['qty'] = $value;
                        $stockMoveNew[$i]['price'] = $itemPrice_new[$i];
                    }
                }
            }
            //d($purchOrderdetailNew,1);
            for ($i=0; $i<count($purchOrderdetailNew); $i++) { 
                DB::table('purch_order_details')->insertGetId($purchOrderdetailNew[$i]);
                DB::table('stock_moves')->insertGetId($stockMoveNew[$i]);
            }
        }

        \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('purchase/list');
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
            $record = \DB::table('purch_orders')->where('order_no', $id)->first();
            if($record) {
                DB::table('purch_orders')->where('order_no', '=', $record->order_no)->delete();
                DB::table('purch_order_details')->where('order_no', '=', $record->order_no)->delete();
                DB::table('stock_moves')->where('reference', '=', 'store_in_'.$record->order_no)->delete();
                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('purchase/list');
            }
        }
    }

    public function pdfview($id, $r='')
    {
        $supp_id = \DB::table('purch_orders')->where('order_no', $id)->first();
        $data['supplierData'] = \DB::table('suppliers')->where('supplier_id', $supp_id->supplier_id)->first();
        $data['invoiceData'] = \DB::table('purch_order_details')->where('order_no', $id)->get();
        
        $data['id'] = $id;

        $pdf = PDF::loadView('pdfviewIn', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->stream('invoice_check_in_'.time().'.pdf',array("Attachment"=>0));
    }

    public function searchItem(Request $request)
    {
        
            $data = array();
            $data['status_no'] = 0;
            $data['message']   ='No Item Found!';
            $data['items'] = array();

            $item = DB::table('stock_master')->where('stock_master.description','LIKE','%'.$request->search.'%')
            ->where(['stock_master.inactive'=>0,'stock_master.deleted_status'=>0])
            ->orWhere('stock_master.stock_id','LIKE','%'.$request->search.'%')
            ->leftJoin('purchase_prices', 'stock_master.stock_id', '=', 'purchase_prices.stock_id')
            ->leftJoin('item_tax_types','item_tax_types.id','=','stock_master.tax_type_id')
            ->leftJoin('item_code','item_code.stock_id','=','stock_master.stock_id')
            ->select('stock_master.*','purchase_prices.price','item_code.id','item_tax_types.tax_rate','item_tax_types.id as tax_id')
            ->get();

            if($item){

                $data['status_no'] = 1;
                $data['message']   ='Item Found';
                $i = 0;

                foreach ($item as $key => $value) {
                    $return_arr[$i]['id'] = $value->id;
                    $return_arr[$i]['stock_id'] = $value->stock_id;
                    $return_arr[$i]['description'] = $value->description;
                    $return_arr[$i]['units'] = $value->units;
                    $return_arr[$i]['price'] = $value->price;
                    $return_arr[$i]['tax_rate'] = $value->tax_rate;
                    $return_arr[$i]['tax_id'] = $value->tax_id;
                    $i++;
                }
                $data['items'] = $return_arr;
                //echo json_encode($return_arr);
            }
            echo json_encode($data);
            exit;     
    }

    /**
    *View Purchase details
    */
    public function viewPurchaseInvoiceDetail($id){
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_compra_for';
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['invoiceItems'] = (new Purchase)->getPurchaseInvoiceByID($id);
       
        $data['purchData'] = DB::table('purch_orders')
                            ->where('order_no', '=', $id)
                            ->leftJoin('suppliers','suppliers.supplier_id','=','purch_orders.supplier_id')
                            ->leftJoin('location','location.loc_code','=','purch_orders.into_stock_location')
                            ->select('purch_orders.*','suppliers.supp_name','suppliers.nuit','suppliers.email','suppliers.address','suppliers.contact','suppliers.city','suppliers.state','suppliers.zipcode','suppliers.country','location.location_name')
                            ->first();
      //d($data['purchData'],1);

        $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');

        $data['payments']   = DB::table('payment_terms')->get();
        
      $invoice_count = DB::table('payment_purchase_history')->count();
      if($invoice_count>0){
        $invoiceReference = DB::table('payment_purchase_history')->select('reference')->orderBy('id','DESC')->first();

        $ref = explode("-",$invoiceReference->reference);
        $data['invoice_count'] = (int) $ref[1];
      }else{
            $data['invoice_count'] = 0 ;
      }

        return view('admin.purchase.purchaseInvoiceDetails', $data);       
    }
    
    /**
    *View Purchase details
    */
    public function invoicePdf($id){
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['invoiceItems'] = (new Purchase)->getPurchaseInvoiceByID($id);
       
        $data['purchData'] = DB::table('purch_orders')
                            ->where('order_no', '=', $id)
                            ->leftJoin('suppliers','suppliers.supplier_id','=','purch_orders.supplier_id')
                            ->select('purch_orders.*','suppliers.supp_name','suppliers.email','suppliers.address','suppliers.contact','suppliers.city','suppliers.state','suppliers.zipcode','suppliers.country')
                            ->first();
        //return view('admin.purchase.invoicePdf', $data);
        $pdf = PDF::loadView('admin.purchase.invoicePdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('purchase_invoice_'.time().'.pdf',array("Attachment"=>0));               
    }
    
    /**
    *Print Purchase details
    */
    public function invoicePrint($id){
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['invoiceItems'] = (new Purchase)->getPurchaseInvoiceByID($id);
       
        $data['purchData'] = DB::table('purch_orders')
                            ->where('order_no', '=', $id)
                            ->leftJoin('suppliers','suppliers.supplier_id','=','purch_orders.supplier_id')
                            ->select('purch_orders.*','suppliers.supp_name','suppliers.email','suppliers.address','suppliers.contact','suppliers.city','suppliers.state','suppliers.zipcode','suppliers.country')
                            ->first();
        //return view('admin.purchase.printPdf', $data);

        $pdf = PDF::loadView('admin.purchase.invoicePrint', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('purchase_invoice_'.time().'.pdf',array("Attachment"=>0));       
    }
    /**
    * Check reference no if exists
    */
    public function referenceValidation(Request $request){
        
        $data = array();
        $ref = $request['ref'];
        $result = DB::table('purch_orders')->where("reference",$ref)->first();

        if(count($result)>0){
            $data['status_no'] = 1; 
        }else{
            $data['status_no'] = 0;
        }

        return json_encode($data);       
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Filtering()
    {
        $data['menu'] = 'purchase';
        $data['supplier'] =  'all';
        $data['stock_id'] =  'all';

        $data['suppliers'] = DB::table('suppliers')
                             ->select('supplier_id as id','supp_name as name')->get();
        $data['items']     = DB::table('item_code')
                              ->select('stock_id','description as name')->get();

        if(empty($_GET)){
        $data['purchData'] = (new Purchase)->getAllPurchOrder();
        $from              = DB::table('purch_orders')->select('ord_date')
                             ->orderBy('ord_date','asc')->first();
       if(!empty($from)){
        $data['from'] = formatDate($from->ord_date);
       }else{
        $data['from'] = formatDate(date('d-m-Y'));
       }
        $data['to'] = formatDate(date('d-m-Y'));
     }else{

        $from = $_GET['from'];
        $to   = $_GET['to'];
        $supplier_id = $_GET['supplier'];
        $stock_id = $_GET['item'];

        if ( $supplier_id == 'all' && $stock_id == 'all' ){
           $data['purchData'] = (new Purchase)->getAllPurchOrderFiltering($from,$to,'all','all');
        }elseif ($supplier_id != 'all' && $stock_id == 'all') {
           $data['purchData'] = (new Purchase)->getAllPurchOrderFiltering($from,$to,$supplier_id,'all');
        }
        elseif ($supplier_id == 'all' && $stock_id != 'all') {
           $data['purchData'] = (new Purchase)->getAllPurchOrderFiltering($from,$to,'all',$stock_id);
        }
        elseif ($supplier_id != 'all' && $stock_id != 'all') {
           $data['purchData'] = (new Purchase)->getAllPurchOrderFiltering($from,$to,$supplier_id,$stock_id);
        }

        $data['from'] =  $_GET['from'];
        $data['to'] =  $_GET['to'];
        $data['supplier'] =  $_GET['supplier'];
        $data['stock_id'] =  $_GET['item'];


     }


     return view('admin.purchase.filtering_list', $data);
    }

    public function report()
    {
        $data['purchData'] = (new Purchase)->getAllPurchOrder();
        $pdf = PDF::loadView('admin.purchase.report.purchasesReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Compras'.time().'.pdf',array("Attachment"=>0));
    }

    public function reportVD()
    {
       $data['purchVDData']=DB::table('purchase_vd')
                            ->leftjoin('suppliers','suppliers.supplier_id','=','purchase_vd.supplier_no_vd')
                            ->select('purchase_vd.*', 'suppliers.supp_name','suppliers.nuit')
                            ->orderBy('purchase_vd.vd_date', 'desc')
                            ->get();
        $pdf = PDF::loadView('admin.purchase.report.purchaseVDReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Compras a Dinheiro'.time().'.pdf',array("Attachment"=>0));
    }

}
