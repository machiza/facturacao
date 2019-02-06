<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class SubscricaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'subscrition';
        $data['subscricoes'] =  DB::table('subscricoes')
        ->leftjoin('planos','subscricoes.plano_id','=','planos.id')
        ->leftjoin('produtos','subscricoes.produto_id','=','produtos.id')
        ->leftjoin('users','subscricoes.user_id','=','users.id')
        ->leftjoin('debtors_master as p','subscricoes.customer_id','=','p.debtor_no')
         ->leftjoin('debtors_master','subscricoes.cliente_final_id','=','debtors_master.debtor_no')
        ->select('subscricoes.*','subscricoes.id as ordem','planos.nome as plano','produtos.*','users.real_name as usuario','debtors_master.name as cliente_final','p.name as cliente')
        ->orderBy('subscricoes.id','desc')->get();

        $data['patners'] = DB::table('debtors_master')->where(['status_debtor'=>'activo','tipo_cliente'=>'parceiro'])->get();

         $data['customers'] = DB::table('debtors_master')->where(['inactive'=>0,'status_debtor'=>'activo','tipo_cliente'=>'normal'])->get();

        $data['produtos']= DB::table('produtos')->OrderBy('id','desc')->get();
        $data['planos']= DB::table('planos')->OrderBy('id','desc')->get();


        return view('admin.subscription.subscription_list', $data);




    }

    
   


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    $data['menu'] = 'sales';
    $data['sub_menu'] = 'subscrition';
    $data['subscricoes'] =  DB::table('subscricoes')->orderBy('id','desc')->get();
    $data['produtos']= DB::table('produtos')->OrderBy('id','desc')->get();
    $data['planos']= DB::table('planos')->OrderBy('id','desc')->get();
    $data['patners'] = DB::table('debtors_master')->where(['status_debtor'=>'activo','tipo_cliente'=>'parceiro'])->get();

    $data['customers'] = DB::table('debtors_master')->where(['status_debtor'=>'activo','tipo_cliente'=>'normal'])->get();

    return view('admin.subscription.subscription_add', $data);

        /*
        nome
        produto_id
        plano_id
        valor
        data_inicio
        data_fim
        user_id
        estado*/

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //return $request->all();

         $this->validate($request, [
            'produto_id' => 'required',
            'plano_id' => 'required',
            'valor' => 'required',
            'customer' => 'required',
        ]);

 
        $userId = \Auth::user()->id;
        $data['produto_id'] =$request->produto_id; 
        $data['plano_id'] = $request->plano_id;
        $data['valor'] = $request->valor;
        $data['data_inicio'] = DbDateFormat($request->data_inicio);
        $data['data_fim'] =DbDateFormat($request->data_fim); 
        $data['user_id'] = $userId;
        $data['customer_id'] = $request->customer;
        $data['estado'] = $request->estado;
       
        if($request->r_tipoCliente=="1"){

            if($request->cliente_final_id==""){
                $data['cliente_final_id'] = $request->customer;    
            }else{
               $data['cliente_final_id'] = $request->cliente_final_id; 
            }
         
        }else{
              $data['cliente_final_id'] = $request->customer;    
        }

        
       
        $data['created_at'] = date('Y-m-d H:i:s');
        $id = DB::table('subscricoes')->insertGetId($data);

       

         \Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended("subscrition");


    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'subscrition';
        $data['subscricoes'] =  DB::table('subscricoes')->orderBy('id','desc')->get();
        return view('admin.subscription.subscription_add', $data);

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

       
        $userId = \Auth::user()->id;
        
       // return  $request->all();
     
         $this->validate($request, [
            'produto_id' => 'required',
            'plano_id' => 'required',
            'valor' => 'required',
            'customer' => 'required',
        ]);
        
       /* $data['produto_id'] =$request->produto_id; 
        $data['plano_id'] = $request->plano_id;
        $data['valor'] = $request->valor;
        $data['data_inicio'] = DbDateFormat($request->data_inicio);
        $data['data_fim'] =DbDateFormat($request->data_fim); 
        $data['user_id'] = $userId;
        $data['customer_id'] = $request->customer;
        $data['estado'] = $request->estado;
        */
        $cliente_do_parceiro=0;

        if($request->r_tipoCliente=="1"){
             $cliente_do_parceiro= $data['cliente_final_id'] = $request->cliente_final_id;
        }else{
             $cliente_do_parceiro= $data['cliente_final_id'] = $request->customer;    
        }
       
        $data['created_at'] = date('Y-m-d H:i:s');
       

       $id =DB::table('subscricoes')
            ->where('id', $request->codigo)
            ->update([ 'produto_id'=>$request->produto_id, 
                        'plano_id'=>$request->plano_id,
                        'valor'=>$request->valor,
                        'data_inicio'=>DbDateFormat($request->data_inicio),
                        'data_fim'=>DbDateFormat($request->data_fim),
                        'user_id'=>$userId,
                        'customer_id'=>$request->customer,
                        'estado'=>$request->estado,
                        'cliente_final_id'=>$cliente_do_parceiro,
                        'created_at'=>date('Y-m-d H:i:s')
                    ]);


         \Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended("subscrition");
        
    

    }

      public function editar(Request $request)
    {
      $id = $request->id;
      $subscricao= DB::table('subscricoes')
                       ->leftjoin('users','subscricoes.user_id','=','users.id')
                       ->where('subscricoes.id',$id)->first();
      
       $debtor= DB::table('debtors_master')->where('debtor_no',$subscricao->customer_id)->first();
        
        $return_arr['cliente_kind'] = $debtor->tipo_cliente;
        $return_arr['produto_id'] = $subscricao->produto_id;
        $return_arr['plano_id'] = $subscricao->plano_id;
        $return_arr['data_inicio'] = $subscricao->data_inicio;
        $return_arr['data_fim'] = $subscricao->data_fim;
        $return_arr['user_id'] = $subscricao->user_id;
        $return_arr['customer_id'] = $subscricao->customer_id;
        $return_arr['cliente_final_id'] = $subscricao->cliente_final_id;
        $return_arr['estado'] = $subscricao->estado;
        $return_arr['valor'] = $subscricao->valor;
        $return_arr['usuario'] = $subscricao->real_name;
        $return_arr['id'] = $subscricao->cliente_final_id;
       
        echo json_encode($return_arr);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
       
        $data=  DB::table('subscricoes')->where('id',$id)->delete();
        if(!empty($data)){

            \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('subscrition');
        }


    }
}
