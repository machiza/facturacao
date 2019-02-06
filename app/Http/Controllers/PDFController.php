<?php

namespace App\Http\Controllers;
use DB;
use Mail;
use Auth;
use Illuminate\Http\Request;
use App\Model\Sales;
use App\Model\Orders;
use App\Model\SockMove;
use App\Model\SaleCC;
use App\Model\Senha;
use App\Model\Report;
use App\User;
use Hash;
use App\Model\Consumo;
use App\Http\Requests;
use PDF;


class PDFController extends Controller
{
    





    public function __construct(Report $report)
    {
         $this->report = $report;
        $this->middleware('auth');
    }





     /**
     * Show the form for creating a new Paciente.
     *
     * @return Response
     */
    public function create()
    {
        
        return view('PDF.index');

  

    }


    /**
     * Display a listing of the Paciente.
     *
     * @param Request $request
     * @return Response
     */
    
    public function index(Request $request)
    {

        $id=4;
        $data['total'] = DB::table('senhas')->where('factura_id','=',$id)->count();
        $data['senhas'] = DB::table('senhas')->where('factura_id','=',$id)->get();
        $codgo=DB::table('sales_orders')->where('order_no','=',$id)->first()->debtor_no;

         $data['cliente']=DB::table('debtors_master')->where('debtor_no','=',$codgo)->first()->name;
      



        $dados=($data['total']);

         if (($dados % 2) == 0)
        { 

             $data['limite']=$dados/2;
        }else{

            $data['limite']=$dados/2+1;
        }


        return view('PDF.index',$data);
       


    }

    public function barcodTeste($id,Request $request)
    {
        /*$user = Auth::user();
        $current_password = 'demo';
       
        if (!Hash::check($current_password, $user->password)) {

            //return 'A PWD nao confere';
             return redirect()->intended($_SERVER['HTTP_REFERER']);

        }
        else{
        */

        return $request->all();
                
        $data['total'] = DB::table('senhas')->where('factura_id','=',$id)->count();
        $data['senhas'] = DB::table('senhas')->where('factura_id','=',$id)->get();
        $codgo=DB::table('sales_orders')->where('order_no','=',$id)->first()->debtor_no;
        $data['cliente']=DB::table('debtors_master')->where('debtor_no','=',$codgo)->first()->name;
      
        $dados=($data['total']);

         if (($dados % 2) == 0)
        { 

             $data['limite']=$dados/2;
        }else{

            $data['limite']=$dados/2+1;
        }


         return view('PDF.index',$data);

        //}
        //return view('PDF.teste',$data);
    }


    public function cheques($id)
    {
          
        $data['total'] = DB::table('cheques')->where('emissao_id','=',$id)->count();
        $data['cheques'] = DB::table('cheques')->where('emissao_id','=',$id)->get();
        $codgo=DB::table('emissoes')->where('id','=',$id)->first()->cliente_id;

         $data['cliente']=DB::table('debtors_master')->where('debtor_no','=',$codgo)->first()->name;
      

        return view('PDF.cheques',$data);
        //return view('PDF.teste',$data);
    }



   
    //
     public function customer_report_fechado($inicio, $fim, $id){
 
        $data['inicio']=$inicio;
        $data['fim']=$fim;
        $data['customerInfo']  = DB::table('debtors_master')
                 ->leftjoin('cust_branch','cust_branch.debtor_no','=','debtors_master.debtor_no')
                 ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                 ->where('debtors_master.debtor_no',$id)
                 ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','countries.country','cust_branch.billing_country_id')                            
                 ->first();

        $data['senhas'] =$this->consumo_customer($this->convert($inicio), $this->convert($fim),$id);
        $data['total_valor'] =$this->consumo_customer_total($this->convert($inicio), $this->convert($fim),$id);
        $data['produto'] ="all";
        $data['numero_elemento'] =count($data['senhas']);

        return view('PDF.senha_customer_fechado',$data);
       
    }


     public function sold_report($inicio, $fim){

        $from = date('Y-m-d',strtotime($inicio));
        $to   = date('Y-m-d',strtotime($fim));  
        $from1=$data['from'] =  formatDate($inicio);
        $to1= $data['to']    =  formatDate($fim);

        $data['itemList']=$this->report->getSales_sold($from1,$to1);
        $data['Quantity']=$this->report->getSales_sold_quantidade($from1,$to1);
        $data['venda'] =  $this->report->getSales_sold_venda($from1,$to1);
        $data['custo'] =  $this->report->getSales_sold_custo($from1,$to1);
        $data['inicio'] = $from1;
        $data['fim'] = $to1;

         return view('PDF.sales_sold',$data);
        // return view('admin.report.new.sales_sold', $data);


     }

    /**
     * Store a newly created Paciente in storage.
     *
     * @param CreatePacienteRequest $request
     *
     * @return Response
     */
    public function store(CreatePacienteRequest $request)
    {
       

       //return 'Teve chave shady';
    }

    /**
     * Display the specified Paciente.
     *
     * @param  int $id
     *
     * @return Response
     */
   
        public function reportSale_sold(Request $request)
        {
            $from = date('Y-m-d',strtotime($_GET['from']));
            $to   = date('Y-m-d',strtotime($_GET['to']));  

            $from1=$data['from'] =  formatDate($_GET['from']);
            $to1= $data['to']   =  formatDate($_GET['to']);

            $data['itemList'] =  $this->report->getSales_sold($from1,$to1);
            $data['Quantity'] =  $this->report->getSales_sold_quantidade($from1,$to1);
            $data['venda'] =  $this->report->getSales_sold_venda($from1,$to1);
            $data['custo'] =  $this->report->getSales_sold_custo($from1,$to1);

             return view('admin.report.new.sales_sold', $data);

        }    

}