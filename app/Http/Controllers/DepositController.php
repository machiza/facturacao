<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Bank;
use App\Model\Transaction;
use App\Model\Deposit;
use App\Http\Start\Helpers;
use DB;
use Excel;
use Validator;
use Input;
use Auth;
use Session;
use Image;
use PDF;

class DepositController extends Controller
{
    public function __construct(Bank $bank, Transaction $transaction, Deposit $deposit){
        $this->middleware('auth');
        $this->bank = $bank;
        $this->transaction = $transaction;
        $this->deposit = $deposit;
    }
    /**
     * Display a listing of the Bank Accounts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'deposit/list';
        $data['header'] = 'transaction';
        $data['depositList'] = $this->deposit->getAllDeposits();
        return view('admin.deposit.deposit_list', $data);
    }


    /**
     * Show the form for creating a new Bank Account.
     *
     * @return \Illuminate\Http\Response
     */
    public function addDeposit()
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'deposit/list';
        $data['header'] = 'transaction';
        $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->pluck('name','id');
        $data['payment_methods'] = DB::table('payment_terms')->pluck('name','id');
        return view('admin.deposit.deposit_add', $data);
    }

    /**
     * Store a newly created deposit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $this->validate($request, [
            'account_no' => 'required',
            'trans_date' => 'required',
            'description' =>'required',
            'amount'=>'required',
            'category_id'=>'required',
            'payment_method'=>'required'
        ]);

        $attachment = $request->attachment;
        if(!empty($attachment)){
           $attachmentName = time().'.'.$attachment->getClientOriginalExtension();
           //Move Uploaded File
           $destinationPath = 'uploads/attachment';
           $attachment->move($destinationPath, $attachmentName);

          $data['attachment'] = $attachmentName;
        }
        
        $data['account_no'] = $request->account_no;
        $data['trans_date'] = DbDateFormat($request->trans_date);
        $data['description'] = $request->description;
        $data['amount'] = round(abs($request->amount),2);
        $data['category_id'] = $request->category_id;
        $data['reference'] = $request->reference;
        $data['person_id'] = $userId;
        $data['trans_type'] = 'deposit';
        $data['payment_method'] = $request->payment_method;
        $data['created_at'] = date("Y-m-d H:i:s");

        DB::table('bank_trans')->insert($data);
        
        Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended('deposit/list');

    }

    /**
     * Show the form for editing the deposit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editDeposit($id)
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'deposit/list';
        $data['header'] = 'transaction';
        $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');
        $data['payment_methods'] = DB::table('payment_terms')->pluck('name','id');
        $data['depositInfo'] = DB::table('bank_trans')->where('id',$id)->first();
        return view('admin.deposit.deposit_edit', $data);
    }

    /**
     * Update the specified deposit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDeposit(Request $request)
    {
        $this->validate($request, [
            'account_no' => 'required',
            'trans_date' => 'required',
            'description' =>'required',
            'amount'=>'required',
            'category_id'=>'required',
            'payment_method'=>'required'
        ]);

        $id = $request->id;
        
        $attachment = $request->attachment;
        if(!empty($attachment)){
           $attachmentName = time().'.'.$attachment->getClientOriginalExtension();
           $destinationPath = 'uploads/attachment';
           $attachment->move($destinationPath, $attachmentName);
           
           $oldAttachment = $request->old_attachment;
           if(isset($oldAttachment)){
            $path = base_path('/uploads/attachment/'.$oldAttachment);
            @unlink($path);
            }
           
           $data['attachment'] = $attachmentName;
        }

        $data['account_no'] = $request->account_no;
        $data['trans_date'] = DbDateFormat($request->trans_date);
        $data['description'] = $request->description;
        $data['amount'] = round(abs($request->amount),2);
        $data['category_id'] = $request->category_id;
        $data['reference'] = $request->reference;
        $data['payment_method'] = $request->payment_method;

        DB::table('bank_trans')->where('id', $id)->update($data);

        Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended('deposit/list');
    }

    public function destroy($id)
    {
        if (isset($id)) {
            $record = \DB::table('bank_trans')->where('id', $id)->first();
            if ($record) {
               
               if(!empty($record->attachment)){
                $path = base_path('/uploads/attachment/'.$record->attachment);
                @unlink($path);
                }

                DB::table('bank_trans')->where('id', '=', $id)->delete();
                Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('deposit/list');
            }
        }
    }

    public function report()
    {
        $data['depositList'] = $this->deposit->getAllDeposits();
        $pdf = PDF::loadView('admin.deposit.report.depositsReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Depósitos'.time().'.pdf',array("Attachment"=>0));
    }
}
