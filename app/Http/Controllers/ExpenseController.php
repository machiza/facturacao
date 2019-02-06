<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Bank;
use App\Model\Transaction;
use App\Model\Expense;
use App\Http\Start\Helpers;
use DB;
use Excel;
use Validator;
use Input;
use Auth;
use Session;
use Image;
use PDF;


class ExpenseController extends Controller
{
    public function __construct(Bank $bank, Transaction $transaction, Expense $expense){
        $this->bank = $bank;
        $this->transaction = $transaction;
        $this->expense = $expense;
    }
    /**
     * Display a listing of the Bank Accounts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'expense';
       
        $data['header'] = 'transaction';
        $data['expenseList'] = $this->expense->getAllExpenses();
        return view('admin.expense.expense_list', $data);
    }


    /**
     * Show the form for creating a new Bank Account.
     *
     * @return \Illuminate\Http\Response
     */
    public function addExpense()
    {
        $data['menu'] = 'expense';
        //$data['sub_menu'] = 'expense/list';
        $data['header'] = 'transaction';
        $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','expense')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');
        $data['payment_methods'] = DB::table('payment_terms')->pluck('name','id');
        return view('admin.expense.expense_add', $data);
    }

    /**
     * Store a newly created expense in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $this->validate($request, [
            'account_no' => 'required',
            'trans_date'  => 'required',
            'description' =>'required',
            'amount'     =>'required',
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
        $data['amount'] = '-'.abs(round($request->amount,2));
        $data['category_id'] = $request->category_id;
        $data['reference'] = $request->reference;
        $data['person_id'] = $userId;
        $data['trans_type'] = 'expense';
        $data['payment_method'] = $request->payment_method;
        $data['created_at'] = date("Y-m-d H:i:s");
        
        DB::table('bank_trans')->insert($data);
        
        Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended('expense/list');

    }

    /**
     * Show the form for editing the expense.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function editExpense($id)
    {
        $data['menu'] = 'expense';
        //$data['sub_menu'] = 'expense/list';
        $data['header'] = 'transaction';
        $data['accounts'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','expense')
                                    ->orWhere('type','no')
                                    ->pluck('name','id');
        $data['payment_methods'] = DB::table('payment_terms')->pluck('name','id');
        $data['depositInfo'] = DB::table('bank_trans')->where('id',$id)->first();
        return view('admin.expense.expense_edit', $data);
    }

    /**
     * Update the specified Expense in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateExpense(Request $request)
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
        $data['amount'] = '-'.abs(round($request->amount,2));
        $data['category_id'] = $request->category_id;
        $data['reference'] = $request->reference;
        $data['payment_method'] = $request->payment_method;

        DB::table('bank_trans')->where('id', $id)->update($data);

        Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended('expense/list');
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
                return redirect()->intended('expense/list');
            }
        }
    }


    public function report()
    {

        $data['expenseList'] = $this->expense->getAllExpenses();
        $pdf = PDF::loadView('admin.expense.report.expenseReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Depósitos'.time().'.pdf',array("Attachment"=>0));
    }
    



}
