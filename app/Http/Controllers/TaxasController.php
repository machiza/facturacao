<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Start\Helpers;
use Validator;
use DB;
use Session;
use Carbon\Carbon;
class TaxasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'Parametros';
        $data['sub_menu'] = 'taxas'; 

        $data['taxas'] = DB::table('taxas')
        ->join('moedas','moedas.id','=','taxas.moedas_id')
        ->select('moedas.*','taxas.*','moedas.nome as moeda','taxas.id as taxa')
        ->get(); 
        
        return view('admin.Parametros.Taxas.taxas', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['menu'] = 'Parametros';
        $data['sub_menu'] = 'taxas'; 

         $data['taxas'] = DB::table('taxas')
        ->join('moedas','moedas.id','=','taxas.moedas_id') 
        ->get();

        $data['moedas'] = DB::table('moedas') 
        ->get();
        return view('admin.Parametros.Taxas.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $taxas = array(
            'data_cambio'         => 'required',
            'moedas_id' => 'required',
            'compra' => 'required',
            'venda' => 'required' 
            );


    $validator = Validator::make($request->all(),$taxas);

    if ($validator->fails()) 
    {
        return back()->withErrors($validator)->withInput();
    }
    else
    {
        $dados['data_cambio'] = $request->data_cambio;
        $dados['moedas_id'] = $request->moedas_id;
        $dados['compra'] = $request->compra;
        $dados['venda'] = $request->venda; 
        $dados['created_at'] = Carbon::now();
        DB::table('taxas')->insert($dados); 
        \Session::flash('success',trans('message.success.save_success'));
        return redirect('taxas/add');
    }
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
        $data['menu'] = 'Parametros';
        $data['sub_menu'] = 'taxas'; 

         $data['taxa'] = DB::table('taxas')
        ->join('moedas','moedas.id','=','taxas.moedas_id') 
        ->get();

        $data['moedas'] = DB::table('moedas') 
        ->get();
         
        $data['taxas'] = DB::table('taxas')->where('id',$id)->first();  
        return view('admin.Parametros.Taxas.update', $data);
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
        $taxas = array(
            'data_cambio'         => 'required',
            'moedas_id' => 'required',
            'compra' => 'required',
            'venda' => 'required' 
            );


    $validator = Validator::make($request->all(),$taxas);

    if ($validator->fails()) 
    {
        return back()->withErrors($validator)->withInput();
    }
    else
    {
        $dados['data_cambio'] = $request->data_cambio;
        $dados['moedas_id'] = $request->moedas_id;
        $dados['compra'] = $request->compra;
        $dados['venda'] = $request->venda;  
        $dados['updated_at'] = Carbon::now();
        DB::table('taxas')->where('id',$request->id)->update($dados);
        \Session::flash('success',trans('message.success.save_success'));
        return redirect('taxas');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('taxas')->where('id','=',$id)->delete(); 
         \Session::flash('success',trans('message.success.delete_success'));
        return redirect()->intended('taxas');
    }
}
