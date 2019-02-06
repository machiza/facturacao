<?php

namespace App\Http\Controllers;

use App\Model\GuiaEntrega;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use PDF;
use App\Http\Start\Helpers;

class GEController extends Controller
{
    public function __construct(GuiaEntrega $entrega){
     /**
     * Set the database connection. reference app\helper.php
     */   
        //selectDatabase();
        $this->guia = $entrega;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_guia_entrega';

        $data['guias'] = DB::table('sales_ge')
        ->leftjoin('debtors_master','sales_ge.debtor_no_ge','=','debtors_master.debtor_no')
       ->select("sales_ge.*","debtors_master.*")->orderBy('ge_no', 'desc')
        ->get();

        // Novo 
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : NULL;
        $data['customerList'] = DB::table('debtors_master')->select('debtor_no','name')->where(['inactive'=>0])->get();

        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESINVOICE)->orderBy('ord_date','asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? formatDate(date("d-m-Y", strtotime($fromDate->ord_date))) : formatDate(date('d-m-Y')); 
        $data['to'] = $to = formatDate(date('d-m-Y')); 
        // End Novo

        return view('admin.sale.sales_guia_entrega', $data);
    }



    public function create(){
    	$data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_guia_entrega';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();
        $invoice_count = DB::table('sales_ge')->count();
        if($invoice_count>0){
        $invoiceReference = DB::table('sales_ge')->select('reference_ge')->orderBy('ge_no','DESC')->first();

        $ref = explode("-",$invoiceReference->reference_ge);
        $data['invoice_count'] = (int) $ref[1];
        }else{
            $data['invoice_count'] = 0 ;
        }

        //new:
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
    



        //data para id:
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);

        $data1 = substr($dt, 0, 4);
        $data2 = substr($dt, 5, 2);
        $data3 = substr($dt, 8, 2); 
        if($data1 > 10){
        $data['data_final'] =$data3."-". + $data2."-". + $data1; 
        }else{
        $data['data_final'] = $data3."-". + $data2."-0". + $data1;
        }


    	return view('admin.sale.guiaentrega_add', $data);
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
        $stock_id = $request->stock_id;
        $description = $request->description;
        $taxainclusa = $request->taxainclusa;
        $type = $request->type;
        $itemPrice = $request->item_price; 
        $stock_id = $request->stock_id;
 



        $ge_ref = $request->ge_ref;
        $grandtotal = $request->total;
        $debtor_no = $request->debtor_no;  
        $local_entrega = $request->local_entrega;
        $motorista = $request->motorista;
        $carta = $request->carta;
        $matricula = $request->matricula;
        $data = $request->ge_date;
        $data1 = substr($data, 0, 2);
        $data2 = substr($data, 3, 2);
        $data3 = substr($data, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }
        $comment= $request->comments;

         $sales_ge_Detail['reference_ge'] = $ge_ref;
         $sales_ge_Detail['total'] = $grandtotal;
         $sales_ge_Detail['ge_date'] = $data_final;
         $sales_ge_Detail['local_entrega'] = $local_entrega;
         $sales_ge_Detail['motorista'] = $motorista;
         $sales_ge_Detail['carta'] =$carta;
         $sales_ge_Detail['matricula'] = $matricula;
         $sales_ge_Detail['debtor_no_ge'] =  $debtor_no;
         $sales_ge_Detail['branch_id'] = $debtor_no;
         $sales_ge_Detail['comments'] = $comment;
         $last_id =  DB::table('sales_ge')->insertGetId($sales_ge_Detail);              

                // Inventory Items Start
            if(!empty($description)){
                foreach ($description as $key => $item) {
                $salesOrderDetail['ge_no_id'] = $last_id;
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

                   DB::table('sales_ge_details')->insertGetId($salesOrderDetail);           
                }
            }
                   
          
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('sales/view_detail_ge/'.$last_id);
        

    }


      public function edit($id){

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_guia_entrega';
        
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->where('status_debtor','!=','desactivo')->get();

        $invoice_count = DB::table('sales_ge')->count();
        
        if($invoice_count>0){
        $invoiceReference = DB::table('sales_ge')->select('reference_ge')->orderBy('ge_no','DESC')->first();

        $ref = explode("-",$invoiceReference->reference_ge);
        $data['invoice_count'] = (int) $ref[1];
        }else{
            $data['invoice_count'] = 0 ;
        }

        //new:
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

        //data para id:
        $dt = date("Y/m/d");
        $data['parte_ano'] = substr($dt,  0, 4);

        $data1 = substr($dt, 0, 4);
        $data2 = substr($dt, 5, 2);
        $data3 = substr($dt, 8, 2); 
        if($data1 > 10){
        $data['data_final'] =$data3."-". + $data2."-". + $data1; 
        }else{
        $data['data_final'] = $data3."-". + $data2."-0". + $data1;
        }

        $data['invoiceData'] = DB::table('sales_ge')
                            ->where('ge_no', '=', $id)
                            ->select("sales_ge.*")
                            ->first();


        $data['DataDetalhes'] = $this->guia->getSalseInvoiceByID($id);


        return view('admin.sale.guiaentrega_edit', $data);
    }


     public function update(Request $request)
    {

        $userId = \Auth::user()->id;
        $this->validate($request, [
            'debtor_no' => 'required',
            'local_entrega' => 'required',
        ]);


        $codigo=$request->ge_id;
        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $stock_id = $request->stock_id;
        $description = $request->description;
        $taxainclusa = $request->taxainclusa;
        $type = $request->type;
        $itemPrice = $request->item_price; 
        $stock_id = $request->stock_id;
 

        $ge_ref = $request->ge_ref;
        $grandtotal = $request->total;
        $debtor_no = $request->debtor_no;  
        $local_entrega = $request->local_entrega;
        $motorista = $request->motorista;
        $carta = $request->carta;
        $matricula = $request->matricula;
        $data = $request->ge_date;
        $data1 = substr($data, 0, 2);
        $data2 = substr($data, 3, 2);
        $data3 = substr($data, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }
        $comment= $request->comments;

         $sales_ge_Detail['reference_ge'] = $ge_ref;
         $sales_ge_Detail['total'] = $grandtotal;
         $sales_ge_Detail['ge_date'] = $data_final;
         $sales_ge_Detail['local_entrega'] = $local_entrega;
         $sales_ge_Detail['motorista'] = $motorista;
         $sales_ge_Detail['carta'] =$carta;
         $sales_ge_Detail['matricula'] = $matricula;
         $sales_ge_Detail['debtor_no_ge'] =  $debtor_no;
         $sales_ge_Detail['branch_id'] = $debtor_no;
         $sales_ge_Detail['comments'] = $comment;
         //$last_id =  DB::table('sales_ge')->insertGetId($sales_ge_Detail);     
         DB::table('sales_ge')->where('ge_no', $codigo)->update($sales_ge_Detail);         

             //end pending
         DB::table('sales_ge_details')->where('ge_no_id','=',$codigo)->delete();   
     
            if(!empty($description)){
                foreach ($description as $key => $item) {
                $salesOrderDetail['ge_no_id'] = $codigo;
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

                   DB::table('sales_ge_details')->insertGetId($salesOrderDetail);           
                }
            }
                   
          
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('sales/view_detail_ge/'.$codigo);
        

    }
   //Tes 






    public function viewGe($ge_no){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice_guia_entrega';
        $data['invoiceData'] = DB::table('sales_ge')
                            ->where('ge_no', '=', $ge_no)
                            ->select("sales_ge.*")
                            ->first();

        $data['customerInfo']  = DB::table('debtors_master')
                             ->where('debtors_master.debtor_no',$data['invoiceData']->debtor_no_ge)
                             ->leftjoin('cust_branch','cust_branch.debtor_no','=','debtors_master.debtor_no')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id','cust_branch.nuit')                            
                             ->first();

   
        $id = $data['invoiceData']->ge_no;
        $supp_id = $data['customerInfo']->debtor_no;

        $dt = date("Y/m/d");
        $data['parte_ano']= substr($dt,  0, 4);

     
        $data['nuit_company']= DB::table('preference')
                             ->where('id',20)
                             ->first()->value;                    
        
        $dados = DB::table('sales_ge')
                             ->leftjoin('sales_ge_details','sales_ge.ge_no','=','sales_ge_details.ge_no_id')
                            ->where('ge_no', '=', $ge_no)
                            ->select("sales_ge.*")
                            ->first();

        $data['ge'] =$data['invoiceData']->ge_no;
        $data['ref_ge'] =$data['invoiceData']->reference_ge ;
        $data['local_entrega'] = $data['invoiceData']->local_entrega;
        $data['ge_date'] =$data['invoiceData']->ge_date;
        $data['motorista'] =$data['invoiceData']->motorista;                    
     
        $data['DataDetalhes'] = $this->guia->getSalseInvoiceByID($ge_no);


        return view('admin.sale.view_detail_ge', $data);
    }



    public function gePdf($ge_no){

        $data['invoiceData'] = DB::table('sales_ge')
                            ->where('ge_no', '=', $ge_no)
                            ->select("sales_ge.*")
                            ->first();
                            
        $data['customerInfo']  = DB::table('sales_ge')
                             ->where('sales_ge.ge_no',$ge_no)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_ge.debtor_no_ge')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_ge.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                             ->first();                          
                             

        $pdf = PDF::loadView('admin.invoice.invoiceGEPdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('ge_'.time().'.pdf',array("Attachment"=>0));
    }

    public function gePrint($ge_no){
        $data['invoiceData'] = DB::table('sales_ge')
                            ->where('ge_no', '=', $ge_no)
                            ->select("sales_ge.*")
                            ->first();

        $data['customerInfo']  = DB::table('sales_ge')
                             ->where('sales_ge.ge_no',$ge_no)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_ge.debtor_no_ge')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_ge.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                             ->first();   

        $pdf = PDF::loadView('admin.invoice.invoiceGEPdfPrint', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('ge_'.time().'.pdf',array("Attachment"=>0));        
    }


    public function reporte() {
    
        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESINVOICE)->orderBy('ord_date','asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? date("d-m-Y", strtotime($fromDate->ord_date)) : date('d-m-Y'); 
        $data['to'] = $to = date('d-m-Y');

        $data['entregas'] = DB::table('sales_ge')
                            ->leftjoin('debtors_master','sales_ge.debtor_no_ge','=','debtors_master.debtor_no')
                            ->select("sales_ge.*", "debtors_master.*")->orderBy('ge_no', 'desc')
                            ->get();     

        $pdf = PDF::loadView('admin.sale.reports.GuiaEntregaReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Factura'.time().'.pdf',array("Attachment"=>0));
    }

    public function reporteFilter($dataI,$dataF,$cust) {

        $from = $dataI;
        $to = $dataF;
        $customer = $cust != "all" ? $cust : NULL;
        $location = NULL;   

        $from = DbDateFormat($from); 
        $to = DbDateFormat($to);

        $data['from'] = $from;
        $data['to'] = $to;

        if ($customer != NULL) {
            $data['entregas'] = DB::table('sales_ge')
                        ->leftjoin('debtors_master','sales_ge.debtor_no_ge','=','debtors_master.debtor_no')
                        ->select("sales_ge.*", "debtors_master.*")->orderBy('ge_no', 'desc')
                        ->where('debtors_master.debtor_no','=',$customer)
                        ->where('sales_ge.ge_date','>=',$from)
                        ->where('sales_ge.ge_date','<=',$to)
                        ->get(); 
        } else {
            $data['entregas'] = DB::table('sales_ge')
                        ->leftjoin('debtors_master','sales_ge.debtor_no_ge','=','debtors_master.debtor_no')
                        ->select("sales_ge.*", "debtors_master.*")->orderBy('ge_no', 'desc')
                        ->where('sales_ge.ge_date','>=',$from)
                        ->where('sales_ge.ge_date','<=',$to)
                        ->get(); 
        }
        
        $pdf = PDF::loadView('admin.sale.reports.GuiaEntregaReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Factura'.time().'.pdf',array("Attachment"=>0));
    }



             // removendo o DebitoController
        public function destroy($id){
      
            
               $Guia=DB::table('sales_ge')->where('ge_no',$id)->first();

               $Delalhes_guia=DB::table('sales_ge_details')->where('ge_no_id',$id)->get();

               if($Guia->ge_no!=0){


                    \DB::table('sales_ge')->where('ge_no',$id)->delete();
                    \DB::table('sales_ge_details')->where('ge_no_id',$id)->delete();
                  
                  \Session::flash('success',trans('message.success.delete_success'));
                  return redirect()->intended('sales/guiaentrega');
               }

              \Session::flash('fail','');
               return redirect()->intended('sales/guiaentrega');

        
    }  




}
