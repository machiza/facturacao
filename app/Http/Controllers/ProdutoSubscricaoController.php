<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class ProdutoSubscricaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['sub_menu'] = 'produto_plano';
        $data['menu'] = 'item';
        $data['planos'] = 'item';
        $data['produtos']= DB::table('produtos')->OrderBy('id','desc')->get();
        $data['planos']= DB::table('planos')->OrderBy('id','desc')->get();

        return view('admin.produto_plano.produt_plane', $data);
    

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nome' => 'required|unique:produtos',
        ]);
        $data['nome'] =$request->nome; 
        $data['detalhes'] = $request->descricao;
        $id = DB::table('produtos')->insertGetId($data);

         \Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended("produto/plano");

    }

      public function store_plano(Request $request)
    {
         $this->validate($request, [
            'nome' => 'required|unique:planos',
            'valor' => 'required',
        ]);

        //nome":"Plno Boost ","preco":"2500","descricao
        $data['nome'] =$request->nome; 
        $data['valor'] = $request->valor;
        $data['detalhes'] = $request->descricao;
        $id = DB::table('planos')->insertGetId($data);

        \Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended("produto/plano");

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
    public function edit(Request $request)
    {
        $id = $request->id;
        $produto= DB::table('produtos')->where('id',$id)->first();
        $return_arr['nome'] = $produto->nome;
        $return_arr['detalhes'] = $produto->detalhes;
       
        echo json_encode($return_arr);
    }




    public function edit_plano(Request $request)
    {
        $id = $request->id;
        $plano= DB::table('planos')->where('id',$id)->first();
        
        $return_arr['nome'] = $plano->nome;
        $return_arr['valor'] = $plano->valor;
        $return_arr['detalhes'] = $plano->detalhes;

        echo json_encode($return_arr);

    }


    // Actualizar o plano

     public function update_produto(Request $request)
    {
        //return $request->all();

        $this->validate($request, [
            'nome_produto' => 'required',
        ]);

        $data['nome'] =$request->nome_produto; 
        $data['detalhes'] = $request->detalhes_produto;
        DB::table('produtos')->where('id',$request->id_produto)->update($data);
       
         \Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended("produto/plano");

    }



    public function update_plano(Request $request)
    {

           //return $request->all();

            $this->validate($request, [
            'nome_plano' => 'required',
            'valor_plano' => 'required',
            ]);


            $data['nome'] =$request->nome_plano; 
            $data['valor'] = $request->valor_plano;
            $data['detalhes'] = $request->detalhes_plano;
            
            DB::table('planos')->where('id',$request->plano_id)->update($data);

            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended("produto/plano");

    }


    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $verficar=  DB::table('subscricoes')->where('produto_id',$id)->first();
           
            if(!empty($verficar)){
           
                 \Session::flash('fail',trans('Elimine primeiro a subscricao!'));
                    return redirect()->intended('produto/plano');

            }else{

                     $data=  DB::table('produtos')->where('id',$id)->delete();
                    if(!empty($data)){

                        \Session::flash('success',trans('message.success.delete_success'));
                            return redirect()->intended('produto/plano');
                    }
              }      

    }

    



    public function destroy_plano($id)
    {
       // verficar
        $verficar=  DB::table('subscricoes')->where('plano_id',$id)->first();
           
            if(!empty($verficar)){
           
                 \Session::flash('fail',trans('Elimine primeiro a subscricao!'));
                    return redirect()->intended('produto/plano');

            }else{

                $data=  DB::table('planos')->where('id',$id)->delete();
                if(!empty($data)){

                    \Session::flash('success',trans('message.success.delete_success'));
                    return redirect()->intended('produto/plano');
                }
            }

    }


}
