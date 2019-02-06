<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Start\Helpers;
use Validator;
use DB;
use Session;


class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['list_menu'] = 'bank';
        $data['contas'] = DB::table('bank_account_nr')->get();

        return view('admin.bank_account.bank_account', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['list_menu'] = 'bank';
        return view('admin.bank_account.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conta = array(
            'nome'         => 'required|unique:bank_account_nr',
            'nr_conta' => 'required',
            'nib' => 'required'
            );


    $validator = Validator::make($request->all(),$conta);

    if ($validator->fails()) 
    {
        return back()->withErrors($validator)->withInput();
    }
    else
    {
        $dados['nome'] = $request->nome;
        $dados['nr_conta'] = $request->nr_conta;
        $dados['nib'] = $request->nib;
        $dados['swift'] = $request->swift;
        DB::table('bank_account_nr')->insert($dados); 
        \Session::flash('success',trans('message.success.save_success'));
        return redirect('bank_account');
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
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['list_menu'] = 'bank';
        $data['contas'] = DB::table('bank_account_nr')->where('id',$id)->first();
        return view('admin.bank_account.update', $data);
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
        $conta = array(
            'nome'         => 'required',
            'nr_conta' => 'required',
            'nib' => 'required'
            );


    $validator = Validator::make($request->all(),$conta);

    if ($validator->fails()) 
    {
        return back()->withErrors($validator)->withInput();
    }
    else
    {
        $dados['nome'] = $request->nome;
        $dados['nr_conta'] = $request->nr_conta;
        $dados['nib'] = $request->nib;
        $dados['swift'] = $request->swift;
        DB::table('bank_account_nr')->where('id',$request->id)->update($dados);
        \Session::flash('success',trans('message.success.update_success'));
        return redirect('bank_account');
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
          DB::table('bank_account_nr')->where('id','=',$id)->delete(); 
         \Session::flash('success',trans('message.success.delete_success'));
        return redirect()->intended('bank_account');
    }
}
