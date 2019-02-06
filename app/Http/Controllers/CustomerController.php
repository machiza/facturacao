<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Orders;
use App\Http\Start\Helpers;
use DB;
use Input;
use Excel;
use Validator;
use Session;
use URL;
use PDF;

class CustomerController extends Controller
{
    public function __construct(Orders $orders){
        $this->middleware('auth');
        $this->order = $orders;

    }
    /**
     * Display a listing of the Customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'customer';

        $data['customerData'] = DB::table('debtors_master')
            ->join('cust_branch', 'debtors_master.debtor_no', '=', 'cust_branch.debtor_no')
            ->select('debtors_master.*', 'cust_branch.nuit')
            ->orderBy('debtor_no', 'desc')->where('status_debtor','!=','desactivo')->Orwhere('status_debtor','=',null)->get();

        $data['totalBranch'] = DB::table('cust_branch')->count();
        $data['customerCount'] = DB::table('debtors_master')->where('status_debtor','!=','desactivo')->count();
        $data['customerActive'] = DB::table('debtors_master')->where('inactive', 0)->where('status_debtor','!=', 'desactivo')->count();
        $data['customerInActive'] = DB::table('debtors_master')->where('inactive', 1)->where('status_debtor','!=', 'desactivo')->count();
        //d($data['cusBranchData'],1);
        return view('admin.customer.customer_list', $data);
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'customer';

        $data['countries'] = DB::table('countries')->get();
        $data['sales_types'] = DB::table('sales_types')->get();
        return view('admin.customer.customer_add', $data);
    }


    public function tipo_de_cliente(Request $request)
    {
        $id = $request->id;
        $debtor= DB::table('debtors_master')->where('debtor_no',$id)->first();
        $return_arr['tipo_cliente'] = $debtor->tipo_cliente;
        $return_arr['id'] = $debtor->debtor_no;
       
        echo json_encode($return_arr);
    }


    /**
     * Store a newly created Customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:3',
            //'email' => 'required|email|unique:debtors_master,email',
            'bill_street'=>'required',
            'bill_city'=>'required',
            'nuit'=>'required',
            //'bill_country_id'=>'required'
        ]);
        
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['status_debtor'] = 'activo';
        $data['created_at'] = date('Y-m-d H:i:s');

        $id = DB::table('debtors_master')->insertGetId($data);

        if(!empty($id)) {

            $data2['debtor_no'] = $id;
            $data2['br_name'] = $request->name;
            $data2['billing_street'] = $request->bill_street;
            $data2['billing_city'] = $request->bill_city;
            $data2['billing_state'] = $request->bill_state;
            $data2['billing_zip_code'] = $request->bill_zipCode;
            $data2['billing_country_id'] = 'MZ';
            $data2['shipping_street'] = $request->ship_street;
            $data2['shipping_city'] = $request->ship_city;
            $data2['shipping_state'] = $request->ship_state;
            $data2['shipping_zip_code'] = $request->ship_zipCode;

            //nuit
            $data2['nuit'] = $request->nuit;
            $data2['imposto'] = $request->imposto;
            $data2['discounto'] = $request->discounto;

            $data2['shipping_country_id'] = $request->ship_country_id;
            if($request->info!=""){
                $data2['motivation'] = $request->info;
            }else{
                $data2['motivation']="";
            }
            

            DB::table('cust_branch')->insert($data2);

             \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended("customer/edit/$id");
        } else {

            return back()->withInput()->withErrors(['email' => "Invalid Request !"]);
        }
    }

    
    
    /**
     * Display the specified Customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'customer';

        $data['debtor_no'] = $id;
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();  

        $data['cusBranchData'] = DB::table('cust_branch')->where('debtor_no',$id)->first();
        $data['saleTypeData'] = DB::table('sales_types')->get();
        $data['countries'] = DB::table('countries')->get();
        $data['status_tab'] = 'active';

        //Calculo das facturas
        $total_facturas=DB::table('sales_orders')->where('invoice_type','=','directInvoice')->where('debtor_no','=',$id)->sum('total');

        $total_facturas_Canceladas=DB::table('sales_orders')->where('invoice_type','=','directInvoice')->where('debtor_no','=',$id)->where('status','=','cancelado')->sum('total');


        $total_Pago=DB::table('sales_orders')->where('debtor_no','=',$id)->sum('paid_amount');



        $total_saldos_facturas = 0;
        $total_saldos_facturas = $total_facturas - $total_Pago-$total_facturas_Canceladas;


        //Calculo do debito
        $total_debito=DB::table('sales_debito')->where('debtor_no_debit','=',$id)->sum('debito');

        $total_PagoD=DB::table('sales_debito')->where('debtor_no_debit','=',$id)->sum("paid_amount_debit");

        $total_saldos_debito = 0;
        $total_saldos_debito = $total_debito - $total_PagoD;

          //Calculo do credito
        $total_credito=DB::table('sales_credito')->where('debtor_no_credit','=',$id)->sum('credito');
        $total_PagoC=DB::table('sales_credito')->where('debtor_no_credit','=',$id)->sum("paid_amount_credit");

        $total_saldos_credito = 0;
        $total_saldos_credito = $total_credito - $total_PagoC;

        $saldoCustomer1=$total_saldos_facturas+$total_saldos_debito -$total_saldos_credito;

       // $data['saldoCustomer']=$saldoCustomer1;
        $data['saldoCustomer']=$this->saldoCustomer($id);
        
        return view('admin.customer.customer_edit', $data);
    }





    public function salesOrder($id)
    {
        $data['menu'] = 'customer';
        $data['sub_menu'] = 'sale-order';
        
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();
        $data['salesOrderData'] = $this->order->getAllSalseOrderByCustomer($id);
        return view('admin.customer.customer_sales_order', $data);
    }

    public function invoice($id)
    {
        $data['menu'] = 'customer';
        $data['sub_menu'] = 'invoice';

        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();
        $data['salesOrderData'] = $this->order->getAllSalseInvoiceByCustomer($id);
       // d($data['salesOrderData'],1);
        return view('admin.customer.customer_invoice', $data);
    }

    public function debit($id)
    {
        $data['menu'] = 'customer';
        $data['sub_menu'] = 'debit';
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();

        $data['debitos'] = DB::table('sales_debito')
        ->leftjoin('sales_orders','sales_debito.order_no_id','=','sales_orders.order_no')
        ->leftjoin('debtors_master','sales_debito.debtor_no_debit','=','debtors_master.debtor_no')
        ->select("sales_orders.*", "sales_debito.*","debtors_master.*")->orderBy('debit_no', 'desc')->where('debtors_master.debtor_no', $id)
        ->get();

        $data['Total_por_pagar'] = DB::table('sales_debito')->sum('debito');   
        $data['pago'] = DB::table('sales_debito')->sum('paid_amount_debit');   
        $data['saldo'] = $data['Total_por_pagar']-$data['pago'];

        return view('admin.customer.customer_debit', $data);
    
    }


    public function credit($id)
    {
        $data['menu'] = 'customer';
        $data['sub_menu'] = 'credit';
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();
        $data['creditos'] = DB::table('sales_credito')
        ->leftjoin('sales_orders','sales_credito.order_no_id','=','sales_orders.order_no')
        ->leftjoin('debtors_master','sales_credito.debtor_no_credit','=','debtors_master.debtor_no')
        ->select("sales_orders.*", "sales_credito.*","debtors_master.*")->orderBy('credit_no', 'desc')->where('debtors_master.debtor_no', $id)
        ->get();

        $data['Total_por_pagar'] = DB::table('sales_credito')->sum('credito');   
        $data['pago'] = DB::table('sales_credito')->sum('paid_amount_credit');   
        $data['saldo'] = $data['Total_por_pagar']-$data['pago'];


        return view('admin.customer.customer_credit', $data);
    }



    public function payment($id)
    {
        $data['menu'] = 'customer';
        $data['sub_menu'] = 'payment';
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();
        /*
        $data['paymentList'] = DB::table('payment_history')
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                             ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                             ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                             ->where('sales_orders.debtor_no',$id)
                             ->select('payment_history.*','debtors_master.name','payment_terms.name as pay_type','sales_orders.order_no as invoice_id','sales_orders.order_reference_id as order_id')
                             ->orderBy('payment_date','DESC')
                             ->get();
           */                  


        //d($data['paymentList'],1);
         $data['paymentList'] = DB::table('sales_cc')
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_cc.debtor_no_doc')
                             ->leftjoin('payment_terms','payment_terms.id','=','sales_cc.payment_type_id_doc')
                             ->leftjoin('sales_orders','sales_orders.reference','=','sales_cc.reference_doc')
                             //->leftjoin('payment_history','payment_history.reference','=','sales_cc.reference_doc')
                             ->select('sales_cc.*','debtors_master.name','payment_terms.name as pay_type','sales_orders.order_no as invoice_id','sales_orders.order_reference_id as order_id')
                             ->orderBy('sales_cc.idcc','DESC')->where('payment_type_id_doc','2')->where('debtors_master.debtor_no','=',$id)
                             ->get();


        return view('admin.customer.customer_payment', $data);
    }



    //     
    public function current_account($id)
    {
        $data['menu'] = 'customer';
        $data['sub_menu'] = 'current_account';
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();

        $data['salesOrderData'] = $this->order->getAllSalseInvoiceByCustomer($id);

        $data['correntes']= DB::select("select * from sales_cc where debtor_no_doc =:id or saldo_doc <> null",['id'=>$id]);

        // Novo
        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type', SALESINVOICE)->orderBy('ord_date', 'asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? formatDate(date("d-m-Y", strtotime($fromDate->ord_date))) : formatDate(date('d-m-Y'));
        $data['to'] = $to = formatDate(date('d-m-Y')); 
        // End Novo

        return view('admin.customer.customer_current_account', $data);

    }

    public function current_account_all()
    {
        $data['menu'] = 'report';
        $data['sub_menu'] = 'customers/current_account_all';
        // return $data['clientes'] = DB::table('debtors_master')->select('name')->get();

        // $data['salesOrderData'] = $this->order->getAllSalseInvoiceByCustomer($id);

        // $data['correntes']= DB::select("select * from sales_cc");
        $data['correntes'] = DB::table('sales_cc')
                            ->join('debtors_master', 'sales_cc.debtor_no_doc', '=', 'debtors_master.debtor_no')
                            ->select('sales_cc.*', 'debtors_master.name')
                            ->orderBy('debtors_master.name', 'desc')
                            ->get();

        $data['clientes'] = DB::table('sales_cc')
                            ->join('debtors_master', 'sales_cc.debtor_no_doc', '=', 'debtors_master.debtor_no')
                            ->select('debtors_master.name')
                            ->groupBy('debtors_master.name')
                            ->get();

        // Novo
        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type', SALESINVOICE)->orderBy('ord_date', 'asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? formatDate(date("d-m-Y", strtotime($fromDate->ord_date))) : formatDate(date('d-m-Y'));
        $data['to'] = $to = formatDate(date('d-m-Y')); 
        // End Novo

        return view('admin.customer.customer_current_account_all', $data);

    }

    public function pendente($id)
    {
        $data['menu'] = 'customer';
        $data['sub_menu'] = 'pendentes';
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();

        $data['salesOrderData'] = $this->order->getAllSalseInvoiceByCustomer($id);

        /*
       $data['Pendentes'] = DB::table('sales_cc')
        ->select("sales_cc.*")->orderBy('idcc', 'desc')->where('debtor_no_doc', $id)->where('reference_doc','NOT LIKE','RE%')
        ->where('saldo_doc','<>',0)->Orwhere('saldo_doc','<>',null)->get();
        */

      $data['Pendentes']= DB::select("select * from sales_cc where debtor_no_doc =:id and saldo_doc <> 0 or saldo_doc <> null and status <> 'cancelado' and reference_doc NOT LIKE 'RE%' ",['id'=>$id]);

       $data['saldoCustomer']=$this->saldoCustomer($id);

        return view('admin.customer.customer_pendentes', $data);
        
    }

    public function pendentes_all()
    {     
        $data['menu']     = 'report';
        $data['sub_menu'] = 'customers/pendentes';
        $data['customerData'] = DB::table('debtors_master')->get();

        $data['Pendentes']= DB::select("select c.*, d.*, i.days_before_due from sales_cc c 
                            inner join debtors_master d on c.debtor_no_doc = d.debtor_no
                            left join sales_orders o on c.reference_doc = o.reference
                            left join invoice_payment_terms i on o.payment_term = i.id
                            where saldo_doc <> 0 or c.saldo_doc <> null and c.status <> 'cancelado' 
                            and c.reference_doc NOT LIKE 'RE%' ORDER BY c.debtor_no_doc");

        $data['contas']= DB::select("select debtors_master.name from sales_cc inner join debtors_master 
                        where debtors_master.debtor_no=sales_cc.debtor_no_doc 
                        and saldo_doc <> 0 or saldo_doc <> null and status <> 'cancelado' 
                        and reference_doc NOT LIKE 'RE%' GROUP BY sales_cc.debtor_no_doc");

        return view('admin.customer.customers_pendentes', $data);   
    }


    public function pendentes_all_pdf()
    { 
        $data['Pendentes']= DB::select("select c.*, d.*, i.days_before_due from sales_cc c 
                                inner join debtors_master d on c.debtor_no_doc = d.debtor_no
                                left join sales_orders o on c.reference_doc = o.reference
                                left join invoice_payment_terms i on o.payment_term = i.id
                                where saldo_doc <> 0 or c.saldo_doc <> null and c.status <> 'cancelado' 
                                and c.reference_doc NOT LIKE 'RE%' ORDER BY c.debtor_no_doc");
                                
        $data['contas']= DB::select("select debtors_master.name from sales_cc inner join debtors_master 
                        where debtors_master.debtor_no=sales_cc.debtor_no_doc and saldo_doc <> 0 or saldo_doc <> null 
                        and status <> 'cancelado' and reference_doc NOT LIKE 'RE%' GROUP BY sales_cc.debtor_no_doc");
        
        $pdf = PDF::loadView('admin.customer.pendentes_all_pdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');

        return $pdf->stream('conta corrente_'.time().'.pdf',array("Attachment"=>0));
    }



    public function contacorrentePdf($id){
         //return view('admin.customer.customer_contacorrentePdf', $data);

        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'customer';

        $data['debtor_no'] = $id;
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();
        $data['customerBranchData'] = DB::table('cust_branch')->where('debtor_no', $id)->first();
       
        $data['cusBranchData'] = DB::table('cust_branch')->where('branch_code',$id)->first();
        $data['saleTypeData'] = DB::table('sales_types')->get();
        $data['countries'] = DB::table('countries')->get();
        $data['status_tab'] = 'active';

        $data['correntes']= DB::select("select * from sales_cc where debtor_no_doc =:id or saldo_doc <> null",['id'=>$id]);

        // Novo
        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type', SALESINVOICE)->orderBy('ord_date', 'asc')->first();

        $data['from'] = $from = isset($fromDate->ord_date) ? (date("d-m-Y", strtotime($fromDate->ord_date))) : (date('d-m-Y'));
        $data['to'] = $to = (date('d-m-Y')); 
        // End Novo

        //return view('admin.customer.customer_contacorrentePdf', $data);
        $pdf = PDF::loadView('admin.customer.customer_contacorrentePdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('conta corrente_'.time().'.pdf',array("Attachment"=>0));
    }

    public function contacorrenteFilterPdf($id,$from,$to){
        //return view('admin.customer.customer_contacorrentePdf', $data);

       $data['menu'] = 'relationship';
       $data['sub_menu'] = 'customer';

       $data['debtor_no'] = $id;
       $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();
       $data['customerBranchData'] = DB::table('cust_branch')->where('debtor_no', $id)->first();
      
       $data['cusBranchData'] = DB::table('cust_branch')->where('branch_code',$id)->first();
       $data['saleTypeData'] = DB::table('sales_types')->get();
       $data['countries'] = DB::table('countries')->get();
       $data['status_tab'] = 'active';

       $from = DbDateFormat($from);
       $to = DbDateFormat($to);

       $data['from'] = $from;
       $data['to'] = $to;
    //    $data['correntes']= DB::select("select * from sales_cc where debtor_no_doc =:id",['id'=>$id]);
    //    $data['correntes']= DB::select("select * from sales_cc where debtor_no_doc =:id or saldo_doc <> null
    //                              and ord_date_doc <= :to and ord_date_doc >= :from",
    //                              ['id'=>$id, 'to'=>$to, 'from'=>$from]);
       $data['correntes'] = DB::table('sales_cc')
                            ->where('debtor_no_doc', '=', $id)
                            ->where('ord_date_doc', '<=', $to)
                            ->where('ord_date_doc', '>=', $from)
                            ->get();

       //return view('admin.customer.customer_contacorrentePdf', $data);
       $pdf = PDF::loadView('admin.customer.customer_contacorrentePdf', $data);
       $pdf->setPaper(array(0,0,750,1060), 'portrait');
       return $pdf->stream('conta corrente_'.time().'.pdf',array("Attachment"=>0));
   }

   public function contacorrenteFilterPdfAll(){
        //return view('admin.customer.customer_contacorrentePdf', $data);

        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'customer';

        $data['saleTypeData'] = DB::table('sales_types')->get();
        $data['countries'] = DB::table('countries')->get();
        $data['status_tab'] = 'active';
        //    $data['correntes']= DB::select("select * from sales_cc where debtor_no_doc =:id",['id'=>$id]);
        //    $data['correntes']= DB::select("select * from sales_cc where debtor_no_doc =:id or saldo_doc <> null
        //                              and ord_date_doc <= :to and ord_date_doc >= :from",
        //                              ['id'=>$id, 'to'=>$to, 'from'=>$from]);
        // $data['correntes'] = DB::table('sales_cc')->get();

        $data['correntes'] = DB::table('sales_cc')
                            ->join('debtors_master', 'sales_cc.debtor_no_doc', '=', 'debtors_master.debtor_no')
                            ->select('sales_cc.*', 'debtors_master.name')
                            ->orderBy('debtors_master.name', 'desc')
                            ->get();

        $data['clientes'] = DB::table('sales_cc')
                            ->join('debtors_master', 'sales_cc.debtor_no_doc', '=', 'debtors_master.debtor_no')
                            ->select('debtors_master.name')
                            ->groupBy('debtors_master.name')
                            ->get();

        //return view('admin.customer.customer_contacorrentePdf', $data);
        $pdf = PDF::loadView('admin.customer.customer_contacorrentePdfAll', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('conta corrente_'.time().'.pdf',array("Attachment"=>0));
    }

    public function contacorrente_pendentePdf($id){
         //return view('admin.customer.customer_contacorrentePdf', $data);

        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'customer';

        $data['debtor_no'] = $id;
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();
        $data['customerBranchData'] = DB::table('cust_branch')->where('debtor_no', $id)->first();
       
        $data['cusBranchData'] = DB::table('cust_branch')->where('branch_code',$id)->first();
        $data['saleTypeData'] = DB::table('sales_types')->get();
        $data['countries'] = DB::table('countries')->get();
        $data['status_tab'] = 'active';

        //return view('admin.customer.customer_contacorrentePdf', $data);
        $pdf = PDF::loadView('admin.customer.customer_contacorrente_pendentePdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('conta corrente pendente_'.time().'.pdf',array("Attachment"=>0));
    }

    public function shipment($id)
    {
        $data['menu'] = 'customer';
        $data['sub_menu'] = 'delivery';
        $data['customerData'] = DB::table('debtors_master')->where('debtor_no', $id)->first();
        //$data['salesOrderData'] = $this->order->getAllSalseInvoiceByCustomer($id);
        $data['shipmentList'] = DB::table('shipment')
                ->leftJoin('shipment_details', 'shipment.id', '=', 'shipment_details.shipment_id')
                ->leftJoin('sales_orders','sales_orders.order_no','=','shipment_details.order_no')
                ->leftJoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                ->where('debtors_master.debtor_no', $id)
                ->select('shipment_details.shipment_id','sales_orders.reference','sales_orders.order_no as order_id','debtors_master.name','shipment.packed_date','shipment.status', DB::raw('sum(shipment_details.quantity) as total_shipment'))
                ->groupBy('shipment_details.shipment_id')
                ->orderBy('shipment.packed_date','DESC')
                ->get();
        //d($data,1);

        return view('admin.customer.customer_shipment', $data);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // return $request->all();
        $this->validate($request, [
            'name' => 'required|min:3',
           // 'email' => 'required',
            'phone' => 'required',
            'bill_street'=>'required',
            'bill_city'=>'required',
            'nuit'=>'required',
           // 'billing_country_id'=>'required'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['inactive'] = $request->status;
        $data['tipo_cliente'] = $request->tipo_cliente;
      
        DB::table('debtors_master')->where('debtor_no', $id)->update($data);

        $branch['billing_street'] = $request->bill_street;
        $branch['billing_city'] = $request->bill_city;
        $branch['billing_state'] = $request->bill_state;
        $branch['billing_zip_code'] = $request->bill_zipCode;

        $branch['nuit'] = $request->nuit;
        


        $branch['billing_country_id'] = $request->billing_country_id;

        $branch['shipping_street'] = $request->bill_street;
        $branch['shipping_city'] = $request->bill_city;
        $branch['shipping_state'] = $request->bill_state;
        $branch['shipping_zip_code'] = $request->ship_zipCode;
        $branch['imposto'] = $request->imposto;
        $branch['discounto'] = $request->discounto;
        $branch['shipping_country_id'] = $request->shipping_country_id;
        $branch['motivation'] = $request->info;

        DB::table('cust_branch')->where('debtor_no', $id)->update($branch);





        \Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended('customer/list');
    }



    public function salvar($nome,$email,$phone,$cidade, $endereco,$provincia,$nuit){

        $data['name'] = $nome;
        if($email==""){
          $data['email'] = "";
        }else{
            $data['email'] = $email;
        }
        if($phone==""){
            $data['phone'] ="";
        }else{
            $data['phone'] = $phone;    
        }
        

        //$data['sales_type'] = $request->sales_type;
        $data['created_at'] = date('Y-m-d H:i:s');
        $id = DB::table('debtors_master')->insertGetId($data);

        if(!empty($id)) {

            $data2['debtor_no'] = $id;
            $data2['br_name'] = $nome;
            $data2['billing_street'] = $endereco;

            if($endereco==""){
                 $data2['billing_street'] ="";
            }else{
               $data2['billing_street'] = $endereco;
            }
       

            if($provincia==""){
                 $data2['billing_city'] ="";
            }else{
               $data2['billing_city'] = $cidade;
            }
       
            if($provincia==""){
                 $data2['billing_state'] ="";
            }else{
                 $data2['billing_state'] =$provincia;     
            }


            if($nuit==""){
                 $data2['nuit'] = "";
            }else{
                  $data2['nuit'] = $nuit;
            }

            
           
            $data2['billing_country_id'] = 'MZ';
            $data2['shipping_street'] = "";
            $data2['shipping_city'] = "";
            $data2['shipping_state'] = "";
            $data2['shipping_zip_code'] ="";
            //nuit
           
            // $data2['discounto'] = $request->discounto;
          DB::table('cust_branch')->insert($data2);
    }

}


    public function updatePassword(Request $request)
    {


 //d($request->password,1);

       $this->validate($request, [
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5'
        ]);

        $id = $request->customer_id;

        $password = \Hash::make($request->password);
       

        DB::table('debtors_master')
        ->where('debtor_no', $id)
        ->update(['password' => $password]);

        \Session::flash('success',trans('message.success.update_success'));

        return redirect()->intended("customer/edit/$id");
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(isset($id)) {

            $tabelaCC=  \DB::table('sales_cc')->where('debtor_no_doc', $id)->first();
             $tabelaCredito=  \DB::table('sales_credito')->where('debtor_no_credit', $id)->first();
             $tabelaDebito=  \DB::table('sales_debito')->where('debtor_no_debit', $id)->first();
            $tabelaOrder=  \DB::table('sales_orders')->where('debtor_no', $id)->first();


            if($tabelaCC!=null || $tabelaCredito!=null || $tabelaDebito!=null || $tabelaOrder!=null){

                //return 'imposivel pois o cliente esta associado a outras entidades';
                 \Session::flash('fail',trans('message.error.delete_customer'));
                return redirect()->intended('customer/list');
            }


            $record = \DB::table('debtors_master')->where('debtor_no', $id)->first();
            
            if($record) {
                
                \DB::table('debtors_master')->where('debtor_no', '=', $id)->delete();

                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('customer/list');
            }
        }
    }

    public function downloadCsv($type)
    {
        if ($type == 'xls' ) {
      $customerdata = DB::table('debtors_master')
                              ->leftjoin('cust_branch','debtors_master.debtor_no','=','cust_branch.debtor_no')
                              ->where('status_debtor','!=','desactivo')
                              ->select('debtors_master.*','cust_branch.*')
                              ->groupBy('cust_branch.debtor_no')
                              ->get();
            //d($customerdata,1);

            foreach ($customerdata as $key => $value) {
                $data[$key]['Nome'] = $value->name;
                $data[$key]['Email'] = $value->email;
                $data[$key]['Contacto'] = $value->phone;
                $data[$key]['Nuit'] = $value->nuit;
                
                $data[$key]['endereco'] = $value->billing_street;
                $data[$key]['Cidade'] = $value->billing_city;
                $data[$key]['provincia'] = $value->billing_state; 
               // $data[$key]['Pais'] = trim($value->billing_country_id);
                 
            }
        }

        if( $type == 'sample' ) {
            
            $data[0]['Nome'] = 'Cliente Nome Lda'; 
            $data[0]['Email'] = 'sample@gmail.com';
            $data[0]['Contacto'] = '0123456789';
            $data[0]['Nuit'] = '0123456789';
            
            $data[0]['endereco'] = 'Av de Mocambque Nr 343';
            $data[0]['Cidade'] = 'Cidade de Maputo';
            $data[0]['provincia'] = 'Maputo';
           // $data[0]['Pais'] = 'MZ';

            $type = 'xls';
        }

        return Excel::create('Lista_de_clientes'.time().'', function($excel) use ($data) {
            
            $excel->sheet('primera', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
            
        })->download($type);
    }

    public function import()
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'customer';
        
        return view('admin.customer.customer_import', $data);
    }


      public function importExcel(Request $request)
    {
        
        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    
                $this->salvar($value->nome,$value->email,$value->contacto,$value->cidade,$value->endereco,$value->provincia,$value->nuit);

                }

                   Session::flash('success',trans('message.table.Import'));
                     return back();

            }
        }
         \Session::flash('fail','Falha na Importacao de Dados');
        return back();
        
    }


    public function importCsv(Request $request)
    {

        $file = $request->file('import_file');
        
        $validator = Validator::make(
            [
                'file'      => $file,
                'extension' => strtolower($file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:csv',
            ]
        );

        if($validator->fails()){
            return back()->withErrors(['email' => "File type Invalid !"]);
        }

        if (Input::hasFile('import_file')) {
                $path = Input::file('import_file')->getRealPath();
            
            $csv = array_map('str_getcsv', file($path));

            $unMatch = [];
            $header = array("Customer", "Email", "Phone", "Branch", "Billing Street","Billing City","Billing State","Billing Country","Billing Zipcode", "Shipping Street","Shipping City","Shipping State","Shipping Country","Shipping Zipcode",);

            for ($i=0; $i < sizeof($csv[0]); $i++) {
                if (! in_array($csv[0][$i], $header)) {
                    $unMatch[] = $csv[0][$i];
                }
            }

            if(!empty($unMatch)){

                return back()->withErrors(['email' => "Please Check Csv Header Name !"]);
            }
            
            $data = [];
            foreach ($csv as $key => $value) {
                if($key != 0) {
                    
                    $data[$key]['customer_name'] = $value[0];
                    $data[$key]['email'] = $value[1];
                    $data[$key]['phone'] = $value[2];

                    $data[$key]['billing_street'] = $value[3];
                    $data[$key]['billing_city'] = $value[4];
                    $data[$key]['billing_state'] = $value[5];
                    $data[$key]['billing_zip_code'] = $value[6];
                    $data[$key]['billing_country_id'] = $value[7];
                    

                    $data[$key]['shipping_street'] = $value[8];
                    $data[$key]['shipping_city'] = $value[9];
                    $data[$key]['shipping_state'] = $value[10];
                    $data[$key]['shipping_zip_code'] = $value[11]; 
                    $data[$key]['shipping_country_id'] = $value[12];
                                       

                }
            }
            //d($data,1);

            if (!empty($data) ) {

                foreach ($data as $key => $value) {
                    
                    $email = DB::table('debtors_master')->where('email','=',$value['email'])->count();
                    
                    if ($email == 0) {

                        $cusData[] = [
                                'name' => $value['customer_name'],
                                'email' => $value['email'],
                                'phone' => $value['phone'],
                            ];
                        $cusBrData[] = [
                                'br_name' => $value['customer_name'],
                                'billing_street' => $value['billing_street'],
                                'billing_city' => $value['billing_city'],
                                'billing_state' => $value['billing_state'],
                                'billing_country_id' => $value['billing_country_id'],
                                'billing_zip_code' => $value['billing_zip_code'],

                                'shipping_street' => $value['shipping_street'],
                                'shipping_city' => $value['shipping_city'],
                                'shipping_state' => $value['shipping_state'],
                                'shipping_country_id' => $value['shipping_country_id'],
                                'shipping_zip_code' => $value['shipping_zip_code'],

                            ];
                    }
                }

                
                if (!empty($cusData)) {
                   // DB::table('debtors_master')->insert($cusData);

                for ($i=0; $i < count($cusData) ; $i++) {

                     $insertid[$i]['debtor_no'] = DB::table('debtors_master')->insertGetId($cusData[$i]);
                }

                for ($j=0; $j < count($insertid) ; $j++) { 
                    $cusBrData[$j]['debtor_no'] = $insertid[$j]['debtor_no'];
                    
                }

                DB::table('cust_branch')->insert($cusBrData);

                    
                    \Session::flash('success',trans('message.success.import_success'));
                    return redirect()->intended('customer/list');
                }else{
                        return back()->withErrors(['email' => "Please Check Csv File !"]);
                    }
            }
        }
        return back();
    }

    public function storeBranch()
    {
        $data['br_name'] = $_POST['br_name'];
        $data['br_contact'] = $_POST['br_contact'];
//        $data['br_address'] = $_POST['br_address'];
        $data['billing_street'] = $_POST['bill_street'];
        $data['billing_city'] = $_POST['bill_city'];
        $data['billing_state'] = $_POST['bill_state'];
        $data['billing_zip_code'] = $_POST['bill_zipCode'];
        $data['billing_country_id'] = $_POST['bill_country_id'];
        $data['shipping_street'] = $_POST['ship_street'];
        $data['shipping_city'] = $_POST['ship_city'];
        $data['shipping_state'] = $_POST['ship_state'];
        $data['shipping_zip_code'] = $_POST['ship_zipCode'];
        $data['shipping_country_id'] = $_POST['ship_country_id'];
        $data['debtor_no'] = $_POST['cus_id'];

        $br_id = DB::table('cust_branch')->insertGetId($data);

        if($br_id) {

            $return_arr['success'] = 1;
            $return_arr['br_name'] = $data['br_name'];
            $return_arr['br_contact'] = $data['br_contact'];
            
            $return_arr['br_id'] = $br_id;
        

            echo json_encode($return_arr);
        }
    }


    public function editBranch()
    {
        $id = $_POST['id'];
        $branch = DB::table('cust_branch')->where('branch_code', $id)->first();
        
        if($branch) {
            $return_arr['br_id'] = $id;
            $return_arr['br_name'] = $branch->br_name;
            $return_arr['br_contact'] = $branch->br_contact;
           // $return_arr['br_address'] = $branch->br_address;
            
            $return_arr['billing_street'] = $branch->billing_street;
            $return_arr['billing_city'] = $branch->billing_city;
            $return_arr['billing_state'] = $branch->billing_state;
            $return_arr['billing_zip_code'] = $branch->billing_zip_code;
            $return_arr['billing_country_id'] = $branch->billing_country_id;

            $return_arr['shipping_street'] = $branch->shipping_street;
            $return_arr['shipping_city'] = $branch->shipping_city;
            $return_arr['shipping_state'] = $branch->shipping_state;
            $return_arr['shipping_zip_code'] = $branch->shipping_zip_code;
            $return_arr['shipping_country_id'] = $branch->shipping_country_id;

            echo json_encode($return_arr);
        }
    }

    public function updateBranch()
    {
        $data['br_name'] = $_POST['br_name'];
        $data['br_contact'] = $_POST['br_contact'];
        //$data['br_address'] = $_POST['br_address'];
        $data['billing_street'] = $_POST['bill_street'];
        $data['billing_city'] = $_POST['bill_city'];
        $data['billing_state'] = $_POST['bill_state'];
        $data['billing_zip_code'] = $_POST['bill_zipCode'];
        $data['billing_country_id'] = $_POST['billing_country_id'];

        $data['shipping_street'] = $_POST['ship_street'];
        $data['shipping_city'] = $_POST['ship_city'];
        $data['shipping_state'] = $_POST['ship_state'];
        $data['shipping_zip_code'] = $_POST['ship_zipCode'];
        $data['shipping_country_id'] = $_POST['shipping_country_id'];
        $br_id = $_POST['br_id'];

        DB::table('cust_branch')->where('branch_code', $br_id)->update($data);

        $return_arr['success'] = 1;
        $return_arr['br_name'] = $data['br_name'];
        $return_arr['br_contact'] = $data['br_contact'];
        //$return_arr['br_address'] = $data['br_address'];
        $return_arr['br_id'] = $br_id;
        

        echo json_encode($return_arr);
    }

    public function destroyBranch($id)
    {
        if(isset($id)) {
            $record = \DB::table('cust_branch')->where('branch_code', $id)->first();
            if($record) {
                
                DB::table('cust_branch')->where('branch_code', '=', $id)->delete();

                Session::flash('success',trans('message.success.delete_success'));
                return redirect()->back();
            }
        }
    }

    public function deleteSalesInfo(Request $request){
        $customer_id = $request['customer_id'];
        if($request['action_name'] == 'delete_order'){
            $id = $request['order_no']; 
            //d($id,1);
            if(isset($id)) {
                $record = \DB::table('sales_orders')->where('order_no', $id)->first();
                if($record) {
                    // Delete shipment information
                    DB::table('shipment')->where('order_no', '=', $record->order_no)->delete();
                    DB::table('shipment_details')->where('order_no', '=', $record->order_no)->delete();

                     // Delete Payment information
                    DB::table('payment_history')->where('order_reference', '=', $record->reference)->delete();                

                    // Delete invoice information
                    $invoice = \DB::table('sales_orders')->where('order_reference_id', $record->order_no)->first();
                    
                   // d($invoice,1);
                    DB::table('sales_orders')->where('order_reference_id', '=', $record->order_no)->delete();
                    if(!empty($invoice)){
                    DB::table('sales_order_details')->where('order_no', '=', $invoice->order_no)->delete();
                    }
                    // Delete order information
                    DB::table('sales_orders')->where('order_no', '=', $record->order_no)->delete();
                    DB::table('sales_order_details')->where('order_no', '=', $record->order_no)->delete();

                     // Delete Stock information
                    DB::table('stock_moves')->where('order_no', '=', $record->order_no)->delete();

                    \Session::flash('success',trans('message.success.delete_success'));
                    return redirect()->intended('customer/order/'.$customer_id);
                }
            }
        }elseif($request['action_name'] == 'delete_invoice'){
            $invoice_no = $request['invoice_no']; 

        if(isset($invoice_no)) {
            $record = \DB::table('sales_orders')->where('order_no', $invoice_no)->first();
            if($record) {
                
                $invoice_id = $invoice_no;
                $order_id = $record->order_reference_id;
                $invoice_reference = $record->reference;
                $order_reference = $record->order_reference;

                DB::table('sales_orders')->where('order_no', '=', $invoice_id)->delete();
                DB::table('sales_order_details')->where('order_no', '=', $invoice_id)->delete();
                DB::table('stock_moves')->where('reference', '=', 'store_out_'.$invoice_id)->delete();
                DB::table('payment_history')->where('invoice_reference', '=', $invoice_reference)->delete();

                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('customer/invoice/'.$customer_id);
            }
        }

        }elseif($request['action_name'] == 'delete_payment'){
           $id = $request['payment_no'];

            $paymentInfo = DB::table('payment_history')
                         ->where('id',$id)
                         ->select('id','order_reference','invoice_reference','amount')
                         ->first();
            $totalPaidAmount = DB::table('sales_orders')
                         ->where(['order_reference'=>$paymentInfo->order_reference,'reference'=>$paymentInfo->invoice_reference])
                         ->sum('paid_amount');
            $newAmount   = ($totalPaidAmount-$paymentInfo->amount);
            $update      = DB::table('sales_orders')
                         ->where(['order_reference'=>$paymentInfo->order_reference,'reference'=>$paymentInfo->invoice_reference])
                         ->update(['paid_amount'=>$newAmount]);

            DB::table('payment_history')->where('id',$id)->delete();

         \Session::flash('success',trans('message.success.delete_success'));
         return redirect()->intended('customer/payment/'.$customer_id);
        
        }elseif($request['action_name'] == 'delete_shipment'){
            $shipment_id = $request['shipment_id'];
              $shipments = DB::table('shipment')
                                     ->where('shipment.id',$shipment_id)
                                     ->leftjoin('shipment_details','shipment_details.shipment_id','=','shipment.id')
                                     ->select('shipment_details.id','shipment_details.order_no','shipment_details.stock_id','shipment_details.quantity')
                                     ->get();
              foreach ($shipments as $key => $shipment) {
                $qty = DB::table('sales_order_details')
                     ->where(['order_no'=>$shipment->order_no,'stock_id'=>$shipment->stock_id])
                     ->sum('shipment_qty');
                $newQty = ($qty-$shipment->quantity);
                $updated = DB::table('sales_order_details')
                         ->where(['order_no'=>$shipment->order_no,'stock_id'=>$shipment->stock_id])
                         ->update(['shipment_qty'=>$newQty]);
                
                DB::table('shipment_details')->where(['id'=>$shipment->id])->delete();
              }

              DB::table('shipment')->where(['id'=>$shipment_id])->delete();
              

         \Session::flash('success',trans('message.success.delete_success'));
         return redirect()->intended('customer/shipment/'.$customer_id);
        
        }
    }

    public function report()
    {
       
        $data['customerData'] = DB::table('debtors_master')
            ->join('cust_branch', 'debtors_master.debtor_no', '=', 'cust_branch.debtor_no')->where('status_debtor','!=','desactivo')
            ->select('debtors_master.*', 'cust_branch.nuit')
            ->orderBy('debtor_no', 'desc')->get();


        $pdf = PDF::loadView('admin.customer.reports.clientReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Clientes'.time().'.pdf',array("Attachment"=>0));
    }

    public function saldoCustomer($id){
         //Calculo das facturas
        $total_facturas=DB::table('sales_orders')->where('invoice_type','=','directInvoice')->where('debtor_no','=',$id)->sum('total');

        $total_facturas_Canceladas=DB::table('sales_orders')->where('invoice_type','=','directInvoice')->where('debtor_no','=',$id)->where('status','=','cancelado')->sum('total');


        $total_Pago=DB::table('sales_orders')->where('debtor_no','=',$id)->sum('paid_amount');



        $total_saldos_facturas = 0;
        $total_saldos_facturas = $total_facturas - $total_Pago-$total_facturas_Canceladas;


        //Calculo do debito
        $total_debito=DB::table('sales_debito')->where('debtor_no_debit','=',$id)->sum('debito');

        $total_PagoD=DB::table('sales_debito')->where('debtor_no_debit','=',$id)->sum("paid_amount_debit");

        $total_saldos_debito = 0;
       $total_saldos_debito = $total_debito - $total_PagoD;

          //Calculo do credito
        $total_credito=DB::table('sales_credito')->where('debtor_no_credit','=',$id)->sum('credito');
        $total_PagoC=DB::table('sales_credito')->where('debtor_no_credit','=',$id)->sum("paid_amount_credit");

        $total_saldos_credito = 0;
        $total_saldos_credito = $total_credito - $total_PagoC;

       return $saldoCustomer1=$total_saldos_facturas+$total_saldos_debito -$total_saldos_credito;

        //$data['saldoCustomer']=$saldoCustomer1;



    }


   


}
