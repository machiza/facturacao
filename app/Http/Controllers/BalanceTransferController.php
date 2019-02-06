<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Bank;
use App\Model\Transaction;
use App\Http\Start\Helpers;
use DB;
use Excel;
use Validator;
use Input;
use Auth;
use Session;
use PDF;

class BalanceTransferController extends Controller
{
    public function __construct(Bank $bank, Transaction $transaction){
        $this->middleware('auth');
        $this->bank = $bank;
        $this->transaction = $transaction;
    }
    /**
     * Display a listing of the Bank Accounts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'transfer/list';
        $data['header'] = 'transaction';
        $data['transferList'] = $this->transaction->getAllTransfers();
        //d($data['transferList'],1);
        return view('admin.transfer.transfer_list', $data);
    }


    /**
     * Show the form for creating a new Bank Account.
     *
     * @return \Illuminate\Http\Response
     */
    public function addTransfer()
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'transfer/list';
        $data['header'] = 'transaction';
        $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');
        $data['payment_methods'] = DB::table('payment_terms')->pluck('name','id');
        return view('admin.transfer.transfer_add', $data);
    }

    /**
     * Store a newly created transfer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $this->validate($request, [
            'source' => 'required',
            'destination' => 'required',
            'trans_date' => 'required',
            'description' =>'required',
            'amount'=>'required',
            'payment_method'=>'required'
        ]);

        $balance = DB::table('bank_trans')
                    ->where('account_no',$request->source)
                    ->sum('amount');
        if($request->amount<=$balance){
        // Transfer From Account
        $fromAccount['account_no'] = $request->source;
        $fromAccount['trans_date'] = DbDateFormat($request->trans_date);
        $fromAccount['description'] = $request->description;
        $fromAccount['amount'] = '-'.abs(round($request->amount,2));
        $fromAccount['reference'] = $request->reference;
        $fromAccount['person_id'] = $userId;
        $fromAccount['trans_type'] = 'cash-out-by-transfer';
        $fromAccount['payment_method'] = $request->payment_method;
        DB::table('bank_trans')->insert($fromAccount);

         // Transfered To Account
        $toAccount['account_no'] = $request->destination;
        $toAccount['trans_date'] = DbDateFormat($request->trans_date);
        $toAccount['description'] = $request->description;
        $toAccount['amount'] = abs(round($request->amount,2));
        $toAccount['reference'] = $request->reference;
        $toAccount['person_id'] = $userId;
        $toAccount['trans_type'] = 'cash-in-by-transfer';
        $toAccount['payment_method'] = $request->payment_method;
        DB::table('bank_trans')->insert($toAccount);
        Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended('transfer/list');
    }else{
        return back()->withInput()->withErrors(['email' => "Insufficient balance !"]);
    }

    }

    /**
     * Show the form for editing the Transfer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editTransfer($id)
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'transfer/list';
        $data['header'] = 'transaction';
        $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['payment_methods'] = DB::table('payment_terms')->pluck('name','id');
        $data['transferInfo'] = DB::table('bank_trans')->where('id',$id)->first();
        return view('admin.transfer.transfer_edit', $data);
    }

    /**
     * Update the specified deposit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTransfer(Request $request)
    {
        $this->validate($request, [
            'trans_date' => 'required',
            'description' =>'required',
            'payment_method'=>'required'
        ]);

        $id = $request->id;
        $data['trans_date'] = DbDateFormat($request->trans_date);
        $data['description'] = $request->description;
        $data['reference'] = $request->reference;
        $data['payment_method'] = $request->payment_method;
        //d($data,1);
        DB::table('bank_trans')->where('id', $id)->update($data);

        Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended('transfer/list');
    }

    public function destroy($id)
    {
        if (isset($id)) {
            $record = \DB::table('bank_trans')->where('id', $id)->first();
            if ($record) {
                DB::table('bank_trans')->where('id', '=', $id)->delete();
                Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('transfer/list');
            }
        }
    }

    public function checkBalance(Request $request){
        $account_no = $request->account_no;
        $balance = DB::table('bank_trans')->where('account_no',$account_no)->sum('amount');
        return $balance;

    }

    public function report()
    {
        $data['transferList'] = $this->transaction->getAllTransfers();
        $pdf = PDF::loadView('admin.transfer.report.transferReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Transferências'.time().'.pdf',array("Attachment"=>0));
    }
}
