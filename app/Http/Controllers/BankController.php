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
class BankController extends Controller
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
        $data['sub_menu'] = 'bank/list';
        $data['header'] = 'bank';
        $data['accountList'] = $this->bank->getAccounts();
        
        return view('admin.bank.account_list', $data);
    }


    /**
     * Show the form for creating a new Bank Account.
     *
     * @return \Illuminate\Http\Response
     */
    public function addAccount()
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'bank/add';
        $data['header'] = 'bank';
        $data['accountTypes'] = DB::table('bank_account_type')->get();
        return view('admin.bank.account_add', $data);
    }

    /**
     * Store a newly created Bank Account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAccount(Request $request)
    {
        $userId = Auth::user()->id;
        $this->validate($request, [
            'account_name' => 'required|min:3',
            'account_type_id' => 'required',
            'account_no' =>'required',
            'bank_name'=>'required',
            'opening_balance'=>'required'
        ]);

        $data['account_name'] = $request->account_name;
        $data['account_type_id'] = $request->account_type_id;
        $data['account_no'] = $request->account_no;
        $data['bank_name'] = $request->bank_name;
        $data['bank_address'] = $request->bank_address;
        
        if($request->default_account == 1){
          DB::table('bank_accounts')->update(['default_account'=>0]);
        }

        $data['default_account'] = $request->default_account;
        $id = DB::table('bank_accounts')->insertGetId($data);
        
        if(!empty($id)){
        $trans['account_no'] = $id;
        $trans['amount'] = round($request->opening_balance,2);
        $trans['trans_type'] = 'cash-in';
        $trans['trans_date'] = date('Y-m-d');
        $trans['person_id'] = $userId;
        $trans['reference'] = 'opening balance';
        $trans['category_id'] = 1;
        $trans['payment_method'] = 1;
        $trans['description'] = 'opening balance';
        $data['created_at'] = date("Y-m-d H:i:s");

        DB::table('bank_trans')->insert($trans);
       }

        Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended('bank/list');

    }

    /**
     * Show the form for editing the Account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAccount($tab, $account_id)
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'bank/list';
        $data['header'] = 'bank';
        $data['accountTypes'] = DB::table('bank_account_type')->get();
        $data['accountInfo'] = DB::table('bank_accounts')->where('id', $account_id)->first();
        $data['tab'] = $tab;

        $data['startDate'] = $startDate = date("Y-m-d", strtotime ("-30 day",strtotime(date('d-m-Y') )));
        $data['endDate'] = $endDate = date('Y-m-d');
        
        if(isset($_GET['btn'])){
            $data['startDate'] = $startDate = DbDateFormat($_GET['from']);
            $data['endDate'] = $endDate = DbDateFormat($_GET['to']);
        }

        $data['transactionList'] = $this->transaction->getTransactionByAccountId($startDate, $endDate, $account_id);
        $data['account_id'] = $account_id;
        return view('admin.bank.account_edit', $data);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAccount(Request $request)
    {
        $this->validate($request, [
            'account_name' => 'required|min:3',
            'account_type_id' => 'required',
            'account_no' =>'required',
            'bank_name'=>'required'
        ]);
        $id = $request->id;
        $data['account_name'] = $request->account_name;
        $data['account_type_id'] = $request->account_type_id;
        $data['account_no'] = $request->account_no;
        $data['bank_name'] = $request->bank_name;
        $data['bank_address'] = $request->bank_address;
       
        if($request->default_account == 1){
          DB::table('bank_accounts')->update(['default_account'=>0]);
        }
        
        $data['default_account'] = $request->default_account;

        DB::table('bank_accounts')->where('id', $id)->update($data);

        Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended('bank/list');
    }

    public function bankBalance()
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'bank/balance';
        $data['accountList'] = $this->bank->getAccountsBalance();
        return view('admin.bank.balance_list', $data);
    }

    public function destroy($id)
    {
        if (isset($id)) {
            $record = \DB::table('bank_accounts')->where('id', $id)->first();
            if ($record) {
                DB::table('bank_accounts')->where('id', '=', $id)->update(['deleted'=>1]);
                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('bank/list');
            }
        }
    }

    public function report()
    {
        $data['accountList'] = $this->bank->getAccounts();
        $pdf = PDF::loadView('admin.bank.report.banksReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Bancos'.time().'.pdf',array("Attachment"=>0));
    }

}
