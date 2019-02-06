<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\VD;

use App\Http\Requests;
use App\Model\Sales;
use Ap;
use DB;
use App\Model\SockMove;
use PDF;
use Session;
use Auth;
use App\Http\Start\Helpers;

class VDController extends Controller
{
    public function __construct(Auth $auth, VD $vd){ 
        $this->auth = $auth::user();
        $this->vd = $vd;
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_vd';
       
        $data['vendas'] = DB::table('sales_vd')
        ->leftjoin('debtors_master','sales_vd.debtor_no_vd','=','debtors_master.debtor_no')
        ->select("sales_vd.*","debtors_master.*")->orderBy('vd_no', 'desc')
        ->get();


        //$data['venda'] = DB::table('debtors_master')->where('status_vd','!=','anulado')->get();
        return view('admin.sale.sales_vd', $data);
    }

    public function create(){
    	$data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_vd';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();
        $data['accounts'] = DB::table('bank_accounts')->where(['deleted'=>0])->pluck('account_name','id');

        $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get(); 

        $invoice_count = DB::table('sales_vd')->count();
        if($invoice_count>0){
        $invoiceReference = DB::table('sales_vd')->select('reference_vd')->orderBy('vd_no','DESC')->first();

        $ref = explode("-",$invoiceReference->reference_vd);
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
        



        $data['locData'] = DB::table('location')->get();
        
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);

       
    	return view('admin.sale.vd_add', $data);
    }


       public function edit($id){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_vd';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();
        $data['accounts'] = DB::table('bank_accounts')->where(['deleted'=>0])->pluck('account_name','id');
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get(); 
        $invoice_count = DB::table('sales_vd')->count();

        if($invoice_count>0){
            $invoiceReference = DB::table('sales_vd')->select('reference_vd')->orderBy('vd_no','DESC')->first();
        $ref = explode("-",$invoiceReference->reference_vd);
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
        $data['tax_types'] = $taxTypeList;    

        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";          
        }
        $data['tax_type'] = $selectStart.$taxOptions.$selectEnd;
        $data['tax_type_custom'] = $selectStartCustom.$taxOptions.$selectEndCustom;
        $data['locData'] = DB::table('location')->get();
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);

        $data['inoviceInfo'] = DB::table('sales_vd')
            ->where('vd_no', '=', $id)
            ->select("sales_vd.*")
            ->first(); 


       $data['DataDetalhes'] = $this->vd->getSalseInvoiceByID($id);   


        //new the i am 
        return view('admin.sale.vd_edit', $data);
    


    }






    public function store(Request $request)
    {
    	
       //return $request->all();

        $userId = \Auth::user()->id;
        $this->validate($request, [
            'reference'=>'required|unique:sales_orders',
            'ord_date' => 'required',
            'debtor_no' => 'required',
            'payment_id' => 'required',
            'account_no' => 'required',
        ]);


        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $stock_id = $request->stock_id;
        $description = $request->description;
        $itemPrice = $request->item_price; 
        //s$preco_comp = $request->preco_comp; 
        $taxainclusa = $request->taxainclusa;
        $type = $request->type;
        

        $debtor_no = $request->debtor_no;
        $debtor_no = $request->debtor_no;
        $data_vd = $request->ord_date;
        $ref_vd = $request->reference;
        $payment_id = $request->payment_id;
        $account_no = $request->account_no;
        $comments = $request->comments;
        $total = $request->total;

        $data1 = substr($data_vd, 0, 2);
        $data2 = substr($data_vd, 3, 2);
        $data3 = substr($data_vd, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }

           $salesVD['debtor_no_vd'] = $debtor_no;
           $salesVD['account_no'] = $account_no;
           $salesVD['reference_vd'] = $ref_vd;
           $salesVD['comments'] = $comments;
           $salesVD['vd_date'] = $data_final;
           $salesVD['payment_id'] = $payment_id;
           $salesVD['total'] = $total;
           $last_id = DB::table('sales_vd')->insertGetId($salesVD);

             //nova funcao by sh@dy
        if(!empty($description)){
            foreach ($description as $key => $item) {
         
            $salesOrderDetail['vd_no'] = $last_id;
            $salesOrderDetail['description'] = $description[$key];
            $salesOrderDetail['quantity'] = $itemQuantity[$key];
            $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
            $salesOrderDetail['tax_type_id'] = $taxIds[$key];
            if($taxainclusa[$key]=='yes'){

                $ptUnitario=$unitPrice[$key] - ($unitPrice[$key]*($itemDiscount[$key]/100));
                $ptMontante= $itemPrice[$key]/$itemQuantity[$key];
                $taxa=(($ptUnitario/$ptMontante)-1)*100;

                $NovoPrecoUnitario=$unitPrice[$key]/(1+($taxa/100));
                $salesOrderDetail['unit_price'] = $NovoPrecoUnitario;
                $salesOrderDetail['taxa_inclusa_valor'] = 'yes';
                 
            }else{
                 $salesOrderDetail['unit_price'] = $unitPrice[$key];
                 $salesOrderDetail['taxa_inclusa_valor'] = 'no';
            }

   
             if($type[$key]==0){
                $salesOrderDetail['is_inventory'] = 1;
            }else{
                 $salesOrderDetail['is_inventory'] = 0;
            }

            $salesOrderDetail['stock_id'] = $stock_id[$key];


        DB::table('sales_details_vd')->insertGetId($salesOrderDetail);

            if($stock_id[$key]!="zero"){
                // create stockMove 
                $stockMove['stock_id'] = $stock_id[$key];
                //$stockMove['loc_code'] = 'PL';
                $stockMove['loc_code'] = $request->from_stk_loc;
                $stockMove['tran_date'] = DbDateFormat($request->ord_date);
                $stockMove['person_id'] = $userId;
                $stockMove['reference'] = 'store_out_'.$last_id;
                $stockMove['transaction_reference_id'] =$last_id;
                $stockMove['qty'] = '-'.$itemQuantity[$key];
                $stockMove['trans_type'] = SALESINVOICE;
                $stockMove['order_no'] = $last_id;
                $stockMove['order_reference'] = $request->reference;
                DB::table('stock_moves')->insertGetId($stockMove);
                }

            }
        }
        // Transaction Table

        $data['account_no'] = $request->account_no;//
        $data['trans_date'] = DbDateFormat($request->ord_date);//
        $data['description'] = $request->paymntFor;//
        $data['amount'] = abs($request->total);//
        $data['category_id'] = '1';
        $data['person_id'] = $this->auth->id;
        $data['trans_type'] = 'cash-in-by-sale';//
        $data['payment_method'] = $request->payment_id;
        $data['created_at'] = date("Y-m-d H:i:s");//
        $transactionId = DB::table('bank_trans')->insertGetId($data);


        if(!empty($last_id)){
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('invoice/view-detail-vd/'.$last_id);
        }


    }


    public function update(Request $request)
    {
       //return $request->all();

        $userId = \Auth::user()->id;
        $this->validate($request, [
            'reference'=>'required',
            'ord_date' => 'required',
            'debtor_no' => 'required',
            'payment_id' => 'required',
            'account_no' => 'required',
        ]);

        $last_id=$request->vd_id;   

        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $stock_id = $request->stock_id;
        $description = $request->description;
        $itemPrice = $request->item_price; 
        //s$preco_comp = $request->preco_comp; 
        $taxainclusa = $request->taxainclusa;
        $type = $request->type;
        

        $debtor_no = $request->debtor_no;
        $debtor_no = $request->debtor_no;
        $data_vd = $request->ord_date;
        $ref_vd = $request->reference;
        $payment_id = $request->payment_id;
        $account_no = $request->account_no;
        $comments = $request->comments;
        $total = $request->total;

        $data1 = substr($data_vd, 0, 2);
        $data2 = substr($data_vd, 3, 2);
        $data3 = substr($data_vd, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }

           $salesVD['debtor_no_vd'] = $debtor_no;
           $salesVD['account_no'] = $account_no;
           $salesVD['reference_vd'] = $ref_vd;
           $salesVD['comments'] = $comments;
           $salesVD['vd_date'] = $data_final;
           $salesVD['payment_id'] = $payment_id;
           $salesVD['total'] = $total;
           DB::table('sales_vd')->where('vd_no', $last_id)->update($salesVD); 
         
         DB::table('sales_details_vd')->where('vd_no','=',$last_id)->delete();   
        //nova funcao by sh@dy
        if(!empty($description)){
            foreach ($description as $key => $item) {
         
            $salesOrderDetail['vd_no'] = $last_id;
            $salesOrderDetail['description'] = $description[$key];
            $salesOrderDetail['quantity'] = $itemQuantity[$key];
            $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
            $salesOrderDetail['tax_type_id'] = $taxIds[$key];
            if($taxainclusa[$key]=='yes'){

                $ptUnitario=$unitPrice[$key] - ($unitPrice[$key]*($itemDiscount[$key]/100));
                $ptMontante= $itemPrice[$key]/$itemQuantity[$key];
                $taxa=(($ptUnitario/$ptMontante)-1)*100;

                $NovoPrecoUnitario=$unitPrice[$key]/(1+($taxa/100));
                $salesOrderDetail['unit_price'] = $NovoPrecoUnitario;
                $salesOrderDetail['taxa_inclusa_valor'] = 'yes';
                 
            }else{
                 $salesOrderDetail['unit_price'] = $unitPrice[$key];
                 $salesOrderDetail['taxa_inclusa_valor'] = 'no';
            }

   
             if($type[$key]==0){
                $salesOrderDetail['is_inventory'] = 1;
            }else{
                 $salesOrderDetail['is_inventory'] = 0;
            }

            $salesOrderDetail['stock_id'] = $stock_id[$key];

         DB::table('sales_details_vd')->insertGetId($salesOrderDetail);
         DB::table('stock_moves')->where('order_reference','=',$ref_vd)->delete();   
        
           if($type[$key]==0){
                $stockMove['stock_id'] = $stock_id[$key];
                //$stockMove['loc_code'] = 'PL';
                $stockMove['loc_code'] = $request->from_stk_loc;
                $stockMove['tran_date'] = DbDateFormat($request->ord_date);
                $stockMove['person_id'] = $userId;
                $stockMove['reference'] = 'store_out_'.$last_id;
                $stockMove['transaction_reference_id'] =$last_id;
                $stockMove['qty'] = '-'.$itemQuantity[$key];
                $stockMove['trans_type'] = SALESINVOICE;
                $stockMove['order_no'] = $last_id;
                $stockMove['order_reference'] = $request->reference;
                DB::table('stock_moves')->insertGetId($stockMove);
                }

            }
        }
        // Transaction Table

        $data['account_no'] = $request->account_no;//
        $data['trans_date'] = DbDateFormat($request->ord_date);//
        $data['description'] = $request->paymntFor;//
        $data['amount'] = abs($request->total);//
        $data['category_id'] = '1';
        $data['person_id'] = $this->auth->id;
        $data['trans_type'] = 'cash-in-by-sale';//
        $data['payment_method'] = $request->payment_id;
        $data['created_at'] = date("Y-m-d H:i:s");//
        $transactionId = DB::table('bank_trans')->insertGetId($data);


        if(!empty($last_id)){
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('invoice/view-detail-vd/'.$last_id);
        }


    }

   







    public function viewVDDetails($vdId){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_vd';
        $data['payments']   = DB::table('payment_terms')->get();
        $data['invoiced_status'] = 'yes';

        $data['saleDataInvoice'] = DB::table('sales_vd')
                    ->where('vd_no', '=', $vdId)
                    ->select("sales_vd.*")
                    ->first(); 

        $data['invoiceData'] = $this->vd->getSalseInvoiceByID($vdId);   

        
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
        
        $data['venda'] = DB::table('sales_vd')
        ->leftjoin('debtors_master','sales_vd.debtor_no_vd','=','debtors_master.debtor_no')
        ->select("sales_vd.*","debtors_master.*")->where('vd_no', '=',$vdId)->orderBy('debtor_no', 'desc')
        ->first();
       

        $id = $data['saleDataInvoice']->vd_no;
        $supp_id = $data['saleDataInvoice']->debtor_no_vd;

        $dt = date("Y/m/d");
        $data['parte_ano']=substr($dt,  0, 4);
        $info=DB::table('cust_branch')->where('debtor_no', '=' ,$supp_id)->first();
        if($info!=null || $info!=""){
          $data['nuit']= $info->nuit;
        }else{

            $data['nuit']= "";
        }

        $info2=DB::table('preference')->where('id', '=',20)->first();
        if($info2!=null || $info2!=""){
          $data['nuit_company']= $info2->value;
        }else{

            $data['nuit_company']= "";
        }    


        return view('admin.invoice.viewVDDetails', $data);
    }





    public function vdPdf($vdId){

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_vd';

        $data['saleDataOrder'] = DB::table('sales_vd')
                            ->where('vd_no', '=', $vdId)
                            ->select("sales_vd.*")
                            ->first();
        //$data['invoiceType'] = $data['saleDataOrder']->invoice_type;

        $data['saleDataInvoice'] = DB::table('sales_vd')
                    ->where('vd_no', '=', $vdId)
                    ->select("sales_vd.*")
                    ->first(); 

        $data['invoiceData'] = DB::table('sales_vd')
        ->leftJoin('sales_details_vd','sales_details_vd.vd_no','=','sales_vd.vd_no')
        ->where('sales_vd.vd_no', '=', $vdId)
                    ->select("sales_vd.*", "sales_details_vd.*")
                    ->get();
       
       $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');

        
        

        $data['orderInfo']  = DB::table('sales_vd')->where('vd_no',$vdId)->select('reference_vd','vd_no')->first();

        $data['payments']   = DB::table('payment_terms')->get();

        $pdf = PDF::loadView('admin.invoice.vdPDF', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('vd_'.time().'.pdf',array("Attachment"=>0));
    }

    public function vdPrint($vdId){
        $data['saleDataOrder'] = DB::table('sales_vd')
                            ->where('vd_no', '=', $vdId)
                            ->select("sales_vd.*")
                            ->first();

        $data['saleDataInvoice'] = DB::table('sales_vd')
                    ->where('vd_no', '=', $vdId)
                    ->select("sales_vd.*")
                    ->first(); 

        $data['invoiceData'] = DB::table('sales_vd')
        ->leftJoin('sales_details_vd','sales_details_vd.vd_no','=','sales_vd.vd_no')
        ->where('sales_vd.vd_no', '=', $vdId)
                    ->select("sales_vd.*", "sales_details_vd.*")
                    ->get();
       
       $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');
        $data['orderInfo']  = DB::table('sales_vd')->where('vd_no',$vdId)->select('reference_vd','vd_no')->first();

        $data['payments']   = DB::table('payment_terms')->get();


        $pdf = PDF::loadView('admin.invoice.vdPDFPrint', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('vd_'.time().'.pdf',array("Attachment"=>0));        
    }



      public function reporte(){


         $data['vendas'] = DB::table('sales_vd')
       ->leftjoin('debtors_master','sales_vd.debtor_no_vd','=','debtors_master.debtor_no')
        ->select("sales_vd.*", "debtors_master.*")->orderBy('vd_no', 'desc')
        ->get();     

        $pdf = PDF::loadView('admin.sale.reports.VDReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('GuiaTransporte'.time().'.pdf',array("Attachment"=>0));
    }



        //Funcao para actualizar os estado da factura
        public function editStatus($id,Request $request){

            $result=DB::table('sales_vd')->where('vd_no', $id)->first();

            $texto_vd="Payment for ".$result->reference_vd;
            $descricao_tra="Cancel VD ".$result->reference_vd;

            //actualizar a vd
            $vendaDinheiro['status_vd'] = 'Anulado';
            $vendaDinheiro['sales_vd_description'] =$request->description;
            DB::table('sales_vd')->where('vd_no', $id)->update($vendaDinheiro);
            

           $UpdateStock=SockMove::where("order_no","=",$id)->get();

            if($UpdateStock!=null){

                foreach ($UpdateStock as $UpdateStocks) {
                  if($UpdateStocks->stock_id!='zero'){
                        DB::table('stock_moves')
                        ->where('order_no', $id)
                        ->update(['qty' => 0]);     

                    }

                }
             } 
             //
            //return $UpdateStock=SockMove::where("order_no","=",$id)->get();
            $transaFirst = DB::table('bank_trans')->where('description', $texto_vd)->first();
            //"Payment for VD-0001/2018";
            // Transaction Table
            $valor=$transaFirst->amount*(-1);

            $data['account_no'] = $transaFirst->account_no;//
            $data['trans_date'] = DbDateFormat($transaFirst->trans_date);//
            $data['description'] = $descricao_tra;//
            $data['amount'] =$valor;//
            $data['category_id'] = '1';
            $data['person_id'] = $this->auth->id;
            $data['trans_type'] = 'cash-in-by-sale';//
            $data['payment_method'] =$transaFirst->payment_method;
            $data['created_at'] = date("Y-m-d H:i:s");//
            $transactionId = DB::table('bank_trans')->insertGetId($data);
        
            \Session::flash('success',trans('message.success.save_success'));
             return redirect()->intended('invoice/view-detail-vd/'.$id);
    }











     public function destroy($id)
    {
       
        if(isset($id)) {
           
           // CONDICOES PARA APAGAR
            // verficar se esta anulada ou nao a venda 
           $result=DB::table('sales_vd')->where('vd_no', $id)->first();
           $texto_vd="Payment for ".$result->reference_vd;

            if($result->status_vd=="Anulado"){
                //return "venda Cancelada sera apagada";
                //Apagar os rastos de pagamento da factura

                $descricao_tra="Cancel VD ".$result->reference_vd;
                
                \DB::table('bank_trans')->where('description', $texto_vd)->delete();
                \DB::table('bank_trans')->where('description', $descricao_tra)->delete();
                \DB::table('sales_vd')->where('vd_no', $id)->delete();

                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('sales/vd');

            }else{
            
                //return "venda nao no estado normal deve ser feito o rollback de tudo feito";
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
                 \DB::table('bank_trans')->where('description', $texto_vd)->delete(); 
                  \DB::table('sales_vd')->where('vd_no', $id)->delete();

                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('sales/vd');

                
            }
           
        }
    }




}
