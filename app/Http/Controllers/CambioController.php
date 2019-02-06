<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Start\Helpers;
use Validator;
use DB;
use Session;

class CambioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'Parametros';
        $data['sub_menu'] = 'moedas'; 

        $data['moedas'] = DB::table('moedas')->get();

        return view('admin.Parametros.Moedas.moedas', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['menu'] = 'Parametros';
        $data['sub_menu'] = 'moedas'; 
        return view('admin.Parametros.Moedas.add', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $moedas = array(
            'nome'         => 'required|unique:moedas',
            'singular' => 'required',
            'plural' => 'required',
            'casas_decimais_sing' => 'required',
            'casas_decimais_plu' => 'required' 
            );


    $validator = Validator::make($request->all(),$moedas);

    if ($validator->fails()) 
    {
        return back()->withErrors($validator)->withInput();
    }
    else
    {
        $dados['nome'] = $request->nome;
        $dados['singular'] = $request->singular;
        $dados['plural'] = $request->plural;
        $dados['casas_decimais_sing'] = $request->casas_decimais_sing;
        $dados['casas_decimais_plu'] = $request->casas_decimais_plu;
        DB::table('moedas')->insert($dados); 
        \Session::flash('success',trans('message.success.save_success'));
        return redirect('cambio/add');
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
        $data['sub_menu'] = 'moedas'; 
        $data['moedas'] = DB::table('moedas')->where('id',$id)->first(); 
        return view('admin.Parametros.Moedas.update', $data);
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
        $moedas = array(
            'nome'         => 'required',
            'singular' => 'required',
            'plural' => 'required',
            'casas_decimais_sing' => 'required',
            'casas_decimais_plu' => 'required' 
            );


    $validator = Validator::make($request->all(),$moedas);

    if ($validator->fails()) 
    {
        return back()->withErrors($validator)->withInput();
    }
    else
    {
        $dados['nome'] = $request->nome;
        $dados['singular'] = $request->singular;
        $dados['plural'] = $request->plural;
        $dados['casas_decimais_sing'] = $request->casas_decimais_sing;
        $dados['casas_decimais_plu'] = $request->casas_decimais_plu;
        DB::table('moedas')->where('id',$request->id)->update($dados);
        \Session::flash('success',trans('message.success.save_success'));
        return redirect('cambio');
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
        DB::table('moedas')->where('id','=',$id)->delete(); 
         \Session::flash('success',trans('message.success.delete_success'));
        return redirect()->intended('cambio');
    }
}
