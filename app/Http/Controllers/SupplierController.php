<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Purchase;
use DB;
use Excel;
use Validator;
use Input;
use App\Http\Start\Helpers;

use PDF;
class SupplierController extends Controller
{
    public function __construct(){
     /**
     * Set the database connection. reference app\helper.php
     */   
        //selectDatabase();
    }
    /**
     * Display a listing of the Customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'supplier';

        //inner join com purchorders:
        $data_saldo['supplierData'] = DB::table('suppliers')
            ->join('purch_orders', 'suppliers.supplier_id', '=', 'purch_orders.supplier_id')
            ->select('suppliers.*','purch_orders.saldo')
            ->orderBy('supplier_id', 'desc')->get();

        
        $data['supplierData'] = DB::table('suppliers')->orderBy('supplier_id', 'desc')->get();
        $data['supplierCount'] = DB::table('suppliers')->count();
        $data['supplierActive'] = DB::table('suppliers')->where('inactive', 0)->count();
        $data['supplierInActive'] = DB::table('suppliers')->where('inactive', 1)->count();
      
        
        

        return view('admin.supplier.supplier_list', $data);
    }

    public function orderList($sid)
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'supplier';

        $data['supplierid'] = $sid;
        $data['supplierData'] = \DB::table('suppliers')->where('supplier_id', $sid)->first();
        //d($data['supplierData'],1);
        $data['purchData'] = (new Purchase)->getAllPurchOrderById($sid);
        
        return view('admin.supplier.supplier_order', $data);
    }


    /**
     * Show the form for creating a new Customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'supplier';
        $data['countries'] = DB::table('countries')->get();
        return view('admin.supplier.supplier_add', $data);
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
            'supp_name' => 'required|min:3',
            'email' => 'required',
            'city' =>'required',
            'street'=>'required',
            'nuit'=>'required',
            'country' =>'required'
        ]);

        $data['supp_name'] = $request->supp_name;
        $data['email'] = $request->email;
        $data['address'] = $request->street;
        $data['contact'] = $request->contact;
        $data['city'] = $request->city;
        $data['nuit'] = $request->nuit;
        $data['state'] = $request->state;
        $data['zipcode'] = $request->zipcode;
        $data['country'] = $request->country;

        $data['created_at'] = date('Y-m-d H:i:s');

        $id = \DB::table('suppliers')->insertGetId($data);

        if(!empty($id)){

            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('supplier');
        }else {

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
        $data['sub_menu'] = 'supplier';

        $data['supplierData'] = \DB::table('suppliers')->where('supplier_id', $id)->first();
        $data['countries'] = DB::table('countries')->get();
       // d($data['supplierData'],1);
        return view('admin.supplier.supplier_edit', $data);
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
        $this->validate($request, [
            'supp_name' => 'required|min:3',
            'city' =>'required',
            'street'=>'required',
            //nuit
            'nuit'=>'required',
            'country' =>'required'
        ]);

        $data['supp_name'] = $request->supp_name;
        $data['email'] = $request->email;
        $data['address'] = $request->street;
        $data['contact'] = $request->contact;
        $data['inactive'] = $request->inactive;
        $data['city'] = $request->city;
        $data['state'] = $request->state;
        $data['zipcode'] = $request->zipcode;
        $data['nuit'] = $request->nuit;
        $data['country'] = $request->country;

        $data['updated_at'] = date('Y-m-d H:i:s');
        //d($data,1);
        \DB::table('suppliers')->where('supplier_id', $id)->update($data);

        \Session::flash('success',trans('message.success.update_success'));
            return redirect()->intended('supplier');
    }
    //CC:
    public function current_account($id)
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'supplier';
        $data['supplierData'] = DB::table('suppliers')->where('supplier_id', $id)->first();

        $data['purchData'] = DB::table('purch_orders')
        ->where('supplier_id', $id)
        ->leftjoin('receiptLists','receiptLists.supp_id','=', 'purch_orders.supplier_id')
        ->select('purch_orders.*','receiptLists.supp_id','receiptLists.total_amount')
        ->distinct()->get(['supplier_id']);


        $data['total'] = DB::table("purch_orders")
            ->where('supplier_id', $id)
            ->select(DB::raw("SUM(total) as total_price"))
            ->first();

        $data['saldo'] = DB::table("purch_orders")
            ->where('supplier_id', $id)
            ->select(DB::raw("SUM(valor_pago) as total_saldo"))
            ->first();

        return view('admin.supplier.supplier_current_account', $data);
    }
     public function pendente($id)
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'supplier';
        $data['supplierData'] = DB::table('suppliers')->where('supplier_id', $id)->first();
        $data['purchData'] = DB::table('purch_orders')->where('supplier_id', $id)->get();

        $data['total'] = DB::table("purch_orders")
            ->where('supplier_id', $id)
            ->select(DB::raw("SUM(total) as total_price"))
            ->first();

        $data['saldo'] = DB::table("purch_orders")
            ->where('supplier_id', $id)
            ->select(DB::raw("SUM(valor_pago) as total_saldo"))
            ->first();


        return view('admin.supplier.supplier_pendentes', $data);
    }

    public function pendentes_all()
    {
        $data['menu']     = 'report';
        $data['sub_menu'] = 'suppliers/pendentes';
        $data['supplierData'] = DB::table('suppliers')->get();

        $data['Pendentes'] = DB::table('purch_cc')
                            ->join('suppliers', 'purch_cc.supp_id_doc', '=', 'suppliers.supplier_id')
                            ->where('reference_doc','not like','RE%')
                            ->orderBy('supp_id_doc','desc')
                            ->select('purch_cc.*', 'suppliers.*')
                            ->get();

        $data['contas'] = DB::table('purch_cc')
                            ->join('suppliers', 'purch_cc.supp_id_doc', '=', 'suppliers.supplier_id')
                            ->where('reference_doc','not like','RE%')
                            ->orderBy('supp_id_doc','desc')
                            ->groupBy('suppliers.supp_name') 
                            ->select('suppliers.supp_name')
                            ->get();

        return view('admin.supplier.suppliers_pendentes', $data);
    }

    public function pendentes_all_pdf()
    {
        $data['Pendentes'] = DB::table('purch_cc')
                            ->join('suppliers', 'purch_cc.supp_id_doc', '=', 'suppliers.supplier_id')
                            ->where('reference_doc','not like','RE%')
                            ->orderBy('supp_id_doc','desc')
                            ->select('purch_cc.*', 'suppliers.*')
                            ->get();

        $data['contas'] = DB::table('purch_cc')
                            ->join('suppliers', 'purch_cc.supp_id_doc', '=', 'suppliers.supplier_id')
                            ->where('reference_doc','not like','RE%')
                            ->orderBy('supp_id_doc','desc')
                            ->groupBy('suppliers.supp_name')
                            ->select('suppliers.supp_name')
                            ->get();

        $pdf = PDF::loadView('admin.supplier.pendentes_all_pdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');

        return $pdf->stream('conta corrente_'.time().'.pdf',array("Attachment"=>0));
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
           
            // CONDICOES PARA APAGAR
           // $tabelaCC=  \DB::table('purchase_vd')->where('supplier_no_vd', $id)->first();
            $tabelaCC=  \DB::table('purch_cc')->where('supp_id_doc', $id)->first();
            $tabelaVD=  \DB::table('purchase_vd')->where('supplier_no_vd', $id)->first();
            $tabelaOrder=  \DB::table('purch_orders')->where('supplier_id', $id)->first();


            if($tabelaCC!=null ||  $tabelaVD!=null || $tabelaOrder!=null){

               // return 'imposivel pois o Fornecedor  esta associado a outras entidades';
                 \Session::flash('fail',trans('message.table.answer'));
                return redirect()->intended('supplier');
            }


             $record = \DB::table('suppliers')->where('supplier_id', $id)->first();
            
            if($record) {
                
                \DB::table('suppliers')->where('supplier_id', '=', $id)->delete();

                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('supplier');
            }
        }
    }

    public function downloadCsv($type)
    {
        //d('aaa',1);
        if ($type == 'csv' ) {
            $supplierdata = DB::table('suppliers')->get();
            
            foreach ($supplierdata as $key => $value) {
                $data[$key]['Supplier'] = $value->supp_name;
                $data[$key]['Email'] = $value->email;
                $data[$key]['Phone'] = $value->contact;
                $data[$key]['Street'] = $value->address;
                $data[$key]['City'] = $value->city;
                $data[$key]['State'] = $value->state;
                $data[$key]['Zipcode'] = $value->zipcode;
                $data[$key]['Country'] = $value->country;

            }
        }

        if( $type == 'sample' ) {
            $data[0]['Supplier'] = 'John De'; 
            $data[0]['Email'] = 'example@exmample.com';
            $data[0]['Phone'] = '1235678';
            $data[0]['Street'] = 'North America';
            $data[0]['City'] = 'Washington';
            $data[0]['State'] = 'North America';
            $data[0]['Zipcode'] = '1235678';
            $data[0]['Country'] = 'US';


            $type = 'csv';
        }

        return Excel::create('Suppler_sheet'.time().'', function($excel) use ($data) {
            
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
            
        })->download($type);
    }

    public function import()
    {
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'supplier';
        
        return view('admin.supplier.supplier_import', $data);
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
                //d($csv,1);

                $unMatch = [];
                $header = array("Supplier", "Email", "Phone", "Street", "City","State","Zipcode","Country");

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
                    $data[$key]['supplier_name']  = $value[0];
                    $data[$key]['supplier_email'] = $value[1];
                    $data[$key]['phone']          = $value[2];
                    $data[$key]['address']        = $value[3];
                    $data[$key]['inactive']       = 0;
                    $data[$key]['city']           = $value[4];
                    $data[$key]['state']          = $value[5];
                    $data[$key]['zipcode']        = $value[6];
                    $data[$key]['country']        = $value[7];

                }
            }

            //d($data);

            if (!empty($data)) {
                
                foreach ($data as $key => $value) {
                    
                    $supplierData[] = [
                            'supp_name' => $value['supplier_name'],
                            'email' => $value['supplier_email'],
                            'contact' => $value['phone'],
                            'address' => $value['address'],
                            'inactive' => 0,
                            'city'     =>$value['city'],
                            'state'     =>$value['state'],
                            'zipcode'   =>$value['zipcode'],
                            'country'      =>$value['country'],                
                        ];
                }

                //d($supplierData,1);
                
                if (!empty($supplierData)) {
                    DB::table('suppliers')->insert($supplierData);
                    
                    \Session::flash('success',trans('message.success.import_success'));
                    return redirect()->intended('supplier');
                }else{
                    return back()->withErrors(['email' => "Please check Your CSV file !"]);            
                }
            }
        }
        return back();
    }

    public function contacorrentePdf($id){
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'supplier';

        $data['supplierData'] = DB::table('suppliers')->where('supplier_id', $id)->first();

        $data['purchData'] = DB::table('purch_orders')
        ->where('supplier_id', $id)
        ->leftjoin('receiptLists','receiptLists.supp_id','=', 'purch_orders.supplier_id')
        ->select('purch_orders.*','receiptLists.supp_id','receiptLists.total_amount')
        ->distinct()->get(['supplier_id']);

        $pdf = PDF::loadView('admin.supplier.supplier_cc_pdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('conta corrente_'.time().'.pdf',array("Attachment"=>0));
    }

    public function pendentePdf($id){
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'supplier';
       
        $data['supplierData'] = DB::table('suppliers')->where('supplier_id', $id)->first();
        $data['purchData'] = DB::table('purch_orders')->where('supplier_id', $id)->get();

        $data['total'] = DB::table("purch_orders")
            ->where('supplier_id', $id)
            ->select(DB::raw("SUM(total) as total_price"))
            ->first();

        $data['saldo'] = DB::table("purch_orders")
            ->where('supplier_id', $id)
            ->select(DB::raw("SUM(valor_pago) as total_saldo"))
            ->first();

        $pdf = PDF::loadView('admin.supplier.supplier_pendente_pdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->download('conta pendente_'.time().'.pdf',array("Attachment"=>0));
    }

    public function report()
    {
       
        $data['supplierData'] = DB::table('suppliers')
           ->select('suppliers.*')
            ->orderBy('supplier_id', 'desc')->get();


        $pdf = PDF::loadView('admin.supplier.reports.supplierReports', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Fornecedores'.time().'.pdf',array("Attachment"=>0));
    }

}
