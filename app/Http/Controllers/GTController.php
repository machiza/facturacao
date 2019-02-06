<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\GuiaTransporte;
use App\Http\Requests;

use DB;
use PDF;
use App\Http\Start\Helpers;

class GTController extends Controller
{
    public function __construct(GuiaTransporte $transporte){  
        $this->transporte = $transporte;
    }
    /**

     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_guia_transporte';

         $data['guias'] = DB::table('sales_gt')
        ->leftjoin('debtors_master','sales_gt.debtor_no_gt','=','debtors_master.debtor_no')
       ->select("sales_gt.*","debtors_master.*")->orderBy('gt_no', 'desc')
        ->get();

        // Novo 
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : null;
        $data['customerList'] = DB::table('debtors_master')->select('debtor_no', 'name')->where(['inactive' => 0])->get();

        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type', SALESINVOICE)->orderBy('ord_date', 'asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? formatDate(date("d-m-Y", strtotime($fromDate->ord_date))) : formatDate(date('d-m-Y'));
        $data['to'] = $to = formatDate(date('d-m-Y')); 
        // End Novo

        return view('admin.sale.sales_guia_transporte', $data);
    }

    public function create(){
    	$data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_guia_transporte';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();

        $invoice_count = DB::table('sales_gt')->count();
        if($invoice_count>0){
        $invoiceReference = DB::table('sales_gt')->select('reference_gt')->orderBy('gt_no','DESC')->first();

        $ref = explode("-",$invoiceReference->reference_gt);
        $data['invoice_count'] = (int) $ref[1];
        }else{
            $data['invoice_count'] = 0 ;
        }

        //data para id:
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);

        $data1 = substr($dt, 0, 4);
        $data2 = substr($dt, 5, 2);
        $data3 = substr($dt, 8, 2); 
        if($data1 > 10){
        $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
        $data_final = $data3."-". + $data2."-0". + $data1;
        }
        $data['data_final'] =$data_final;
           
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get();
        
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
    

    	return view('admin.sale.guiatransporte_add', $data);
    }








    public function store(Request $request)
    {
        $userId = \Auth::user()->id;
        $this->validate($request, [
            'debtor_no' => 'required',
            'local_entrega' => 'required',
        ]);

       
        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $description = $request->description;
        $taxainclusa = $request->taxainclusa;
        $type = $request->type;
        $itemPrice = $request->item_price; 
        $stock_id = $request->stock_id;
 

        $ge_ref =$request->ge_ref;
        $grandtotal = $request->total;
        $debtor_no = $request->debtor_no;      
        $local_entrega = $request->local_entrega;
        $motorista = $request->motorista;
        $carta =$request->carta;
        $matricula= $request->matricula;
        $data =$request->gt_date;
        $data1 = substr($data, 0, 2);
        $data2 = substr($data, 3, 2);
        $data3 = substr($data, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }
        $comment= $request->comments;


        $salesGuiaTransporte['reference_gt'] = $ge_ref;
        $salesGuiaTransporte['total'] = $grandtotal;
        $salesGuiaTransporte['gt_date'] = $data_final;
        $salesGuiaTransporte['local_entrega'] = $local_entrega;
        $salesGuiaTransporte['motorista'] = $motorista;
        $salesGuiaTransporte['carta'] = $carta;
        $salesGuiaTransporte['matricula'] = $matricula;
        $salesGuiaTransporte['debtor_no_gt'] = $debtor_no;
        $salesGuiaTransporte['branch_id'] = $debtor_no;
        $salesGuiaTransporte['comments'] = $comment;
        $last_id =DB::table('sales_gt')->insertGetId($salesGuiaTransporte);     
     

        if(!empty($description)){
            foreach ($description as $key => $item) {
          
                $salesOrderDetail['gt_no_id'] = $last_id;
                $salesOrderDetail['description'] = $description[$key];
                $salesOrderDetail['quantity'] = $itemQuantity[$key];
                $salesOrderDetail['trans_type'] = SALESORDER;
                $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
                $salesOrderDetail['tax_type_id'] = $taxIds[$key];
                $salesOrderDetail['stock_id'] = $stock_id[$key];

                 if($taxainclusa[$key]=='yes'){

                $ptUnitario=$unitPrice[$key] - ($unitPrice[$key]*($itemDiscount[$key]/100));
                $ptMontante= $itemPrice[$key]/$itemQuantity[$key];
                $taxa=(($ptUnitario/$ptMontante)-1)*100;

                $NovoPrecoUnitario=$unitPrice[$key]/(1+($taxa/100));
                 $salesOrderDetail['unit_price'] = $unitPrice[$key];
                 $salesOrderDetail['taxa_inclusa_valor'] = 'yes'; 
                }else{
                  $salesOrderDetail['unit_price'] = $unitPrice[$key];
                  $salesOrderDetail['taxa_inclusa_valor'] = 'no';
                }

                if($type[$key]==0){
                     $salesOrderDetail['is_inventory'] = 1;
                }else{
                      $salesOrderDetail['is_inventory'] = 1;

                }

                   DB::table('sales_gt_details')->insertGetId($salesOrderDetail);     


            }
        }
        
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('sales/view_detail_gt/'.$last_id);
        

    }


      public function edit($id){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_guia_transporte';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();

        $invoice_count = DB::table('sales_gt')->count();
        if($invoice_count>0){
        $invoiceReference = DB::table('sales_gt')->select('reference_gt')->orderBy('gt_no','DESC')->first();

        $ref = explode("-",$invoiceReference->reference_gt);
        $data['invoice_count'] = (int) $ref[1];
        }else{
            $data['invoice_count'] = 0 ;
        }

        //data para id:
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);

        $data1 = substr($dt, 0, 4);
        $data2 = substr($dt, 5, 2);
        $data3 = substr($dt, 8, 2); 
        if($data1 > 10){
        $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
        $data_final = $data3."-". + $data2."-0". + $data1;
        }
        $data['data_final'] =$data_final;
           
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get();
        
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
        $data['tax_types'] = $taxTypeList;
        $data['invoiceData'] = DB::table('sales_gt')
                            ->where('gt_no', '=', $id)
                            ->select("sales_gt.*")
                            ->first();


        $data['DataDetalhes'] = $this->transporte->getSalseInvoiceByID($id);



        return view('admin.sale.guiatransporte_edit', $data);
    }


    


    public function update(Request $request)
    {
        $userId = \Auth::user()->id;
        $this->validate($request, [
            'debtor_no' => 'required',
            'local_entrega' => 'required',
        ]);

        $codigo=$request->gt_no;
       
        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $description = $request->description;
        $taxainclusa = $request->taxainclusa;
        $type = $request->type;
        $itemPrice = $request->item_price; 
        $stock_id = $request->stock_id;
 

        $ge_ref =$request->ge_ref;
        $grandtotal = $request->total;
        $debtor_no = $request->debtor_no;      
        $local_entrega = $request->local_entrega;
        $motorista = $request->motorista;
        $carta =$request->carta;
        $matricula= $request->matricula;
        $data =$request->gt_date;
        $data1 = substr($data, 0, 2);
        $data2 = substr($data, 3, 2);
        $data3 = substr($data, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }
        $comment= $request->comments;


        $salesGuiaTransporte['reference_gt'] = $ge_ref;
        $salesGuiaTransporte['total'] = $grandtotal;
        $salesGuiaTransporte['gt_date'] = $data_final;
        $salesGuiaTransporte['local_entrega'] = $local_entrega;
        $salesGuiaTransporte['motorista'] = $motorista;
        $salesGuiaTransporte['carta'] = $carta;
        $salesGuiaTransporte['matricula'] = $matricula;
        $salesGuiaTransporte['debtor_no_gt'] = $debtor_no;
        $salesGuiaTransporte['branch_id'] = $debtor_no;
        $salesGuiaTransporte['comments'] = $comment;

         DB::table('sales_gt')->where('gt_no', $codigo)->update($salesGuiaTransporte);     
         $last_id =$codigo;
      
     
      
        DB::table('sales_gt_details')->where('gt_no_id','=',$codigo)->delete();   

        if(!empty($description)){
            foreach ($description as $key => $item) {
          
                $salesOrderDetail['gt_no_id'] = $last_id;
                $salesOrderDetail['description'] = $description[$key];
                $salesOrderDetail['quantity'] = $itemQuantity[$key];
                $salesOrderDetail['trans_type'] = SALESORDER;
                $salesOrderDetail['discount_percent'] = $itemDiscount[$key];
                $salesOrderDetail['tax_type_id'] = $taxIds[$key];
                $salesOrderDetail['stock_id'] = $stock_id[$key];

                 if($taxainclusa[$key]=='yes'){

                $ptUnitario=$unitPrice[$key] - ($unitPrice[$key]*($itemDiscount[$key]/100));
                $ptMontante= $itemPrice[$key]/$itemQuantity[$key];
                $taxa=(($ptUnitario/$ptMontante)-1)*100;

                $NovoPrecoUnitario=$unitPrice[$key]/(1+($taxa/100));
                 $salesOrderDetail['unit_price'] = $unitPrice[$key];
                 $salesOrderDetail['taxa_inclusa_valor'] = 'yes'; 
                }else{
                  $salesOrderDetail['unit_price'] = $unitPrice[$key];
                  $salesOrderDetail['taxa_inclusa_valor'] = 'no';
                }

                if($type[$key]==0){
                     $salesOrderDetail['is_inventory'] = 1;
                }else{
                      $salesOrderDetail['is_inventory'] = 1;

                }

                   DB::table('sales_gt_details')->insertGetId($salesOrderDetail);     


            }
        }
        
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('sales/view_detail_gt/'.$last_id);
        

    }

    public function viewGt($gt_no){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_guia_transporte';
        $data['invoiceData'] = DB::table('sales_gt')
                            ->where('gt_no', '=', $gt_no)
                            ->select("sales_gt.*")
                            ->first();

        $data['customerInfo']  = DB::table('sales_gt')
                             ->where('sales_gt.gt_no',$gt_no)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_gt.debtor_no_gt')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_gt.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                             ->first();

        return view('admin.sale.view_detail_gt', $data);
    }

    public function gtPdf($gt_no){

        $data['invoiceData'] = DB::table('sales_gt')
                            ->where('gt_no', '=', $gt_no)
                            ->select("sales_gt.*")
                            ->first();
                            
        $data['customerInfo']  = DB::table('sales_gt')
                             ->where('sales_gt.gt_no',$gt_no)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_gt.debtor_no_gt')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_gt.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                             ->first();                          
                             

        $pdf = PDF::loadView('admin.invoice.invoiceGTPdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('gt_'.time().'.pdf',array("Attachment"=>0));
    }

    public function gePrint($gt_no){
        $data['invoiceData'] = DB::table('sales_gt')
                            ->where('gt_no', '=', $gt_no)
                            ->select("sales_gt.*")
                            ->first();

        $data['customerInfo']  = DB::table('sales_gt')
                             ->where('sales_gt.gt_no',$gt_no)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_gt.debtor_no_gt')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_gt.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                             ->first();   

        $pdf = PDF::loadView('admin.invoice.invoiceGTPdfPrint', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('gt_'.time().'.pdf',array("Attachment"=>0));        
    }


      public function reporte() {

        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESINVOICE)->orderBy('ord_date','asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? date("d-m-Y", strtotime($fromDate->ord_date)) : date('d-m-Y'); 
        $data['to'] = $to = date('d-m-Y');

         $data['transportes'] = DB::table('sales_gt')
                                ->leftjoin('debtors_master','sales_gt.debtor_no_gt','=','debtors_master.debtor_no')
                                ->select("sales_gt.*", "debtors_master.*")->orderBy('gt_no', 'desc')
                                ->get();     

        $pdf = PDF::loadView('admin.sale.reports.GuiaTransportReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('GuiaTransporte'.time().'.pdf',array("Attachment"=>0));
    }

    public function reporteFilter($dataI, $dataF, $cust)
    {

        $from = $dataI;
        $to = $dataF;
        $customer = $cust != "all" ? $cust : null;
        $location = null;

        $from = DbDateFormat($from);
        $to = DbDateFormat($to);

        $data['from'] = $from;
        $data['to'] = $to;

        if ($customer != null) {
            $data['transportes'] = DB::table('sales_gt')
                ->leftjoin('debtors_master', 'sales_gt.debtor_no_gt', '=', 'debtors_master.debtor_no')
                ->select("sales_gt.*", "debtors_master.*")->orderBy('gt_no', 'desc')
                ->where('debtors_master.debtor_no', '=', $customer)
                ->where('sales_gt.gt_date', '>=', $from)
                ->where('sales_gt.gt_date', '<=', $to)
                ->get();
        } else {
            $data['transportes'] = DB::table('sales_gt')
                ->leftjoin('debtors_master', 'sales_gt.debtor_no_gt', '=', 'debtors_master.debtor_no')
                ->select("sales_gt.*", "debtors_master.*")->orderBy('gt_no', 'desc')
                ->where('sales_gt.gt_date', '>=', $from)
                ->where('sales_gt.gt_date', '<=', $to)
                ->get();
        }

        $pdf = PDF::loadView('admin.sale.reports.GuiaTransportReport', $data);
        $pdf->setPaper(array(0, 0, 750, 1060), 'portrait');
        return $pdf->stream('GuiaTransporte' . time() . '.pdf', array("Attachment" => 0));
    }

                // removendo o DebitoController
        public function destroy($id){
      

               $Guia=DB::table('sales_gt')->where('gt_no',$id)->first();

               $Delalhes_guia=DB::table('sales_gt_details')->where('gt_no_id',$id)->get();

               if($Guia->gt_no!=0){


                    \DB::table('sales_gt')->where('gt_no',$id)->delete();
                    \DB::table('sales_gt_details')->where('gt_no_id',$id)->delete();
                  
                  \Session::flash('success',trans('message.success.delete_success'));
                  return redirect()->intended('sales/guiatransporte');
               }

               \Session::flash('fail','');
               return redirect()->intended('sales/guiatransporte');

        
    }


}
