<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Transaction;
use DB;
use Excel;
use Auth;
use Session;
use App\Http\Start\Helpers;
use PDF;

class TransactionController extends Controller
{
    public function __construct(Transaction $transaction){
        $this->middleware('auth');
        $this->transaction = $transaction;
    }
    public function index()
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'transaction/list';
        $data['header'] = 'transaction';
        
        $data['accountList'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['categoryList'] = DB::table('income_expense_categories')->pluck('name','id');
        $data['types'] = ['income','expense'];
        $data['from'] = $from = date('Y-m-d', strtotime("-30 days"));
        $data['to'] = $to = date('Y-m-d');
        $data['account_no'] = $account_no = NULL;
        $data['category_id'] = $category_id = NULL;
        $data['type_id'] = $type_id = NULL;

        if(isset($_GET['btn'])){
           $data['from'] = $from = $_GET['from'];
           $data['to'] = $to = $_GET['to'];
           $data['account_no'] = $account_no = $_GET['account_no'];
           $data['category_id'] = $category_id = $_GET['category_id'];
           $data['type_id'] = $type_id = $_GET['type'];

        }

        $data['transactionList'] = $this->transaction->getAllTransactions($from, $to, $account_no, $category_id, $type_id);

        return view('admin.transaction.transaction_list', $data);
    }

    public function expenseReport(){
        $data['menu'] = 'report';
        $data['sub_menu'] = 'transaction/expense-report';
        $data['header'] = 'report';
        $year = date('Y');
        if(isset($_GET['year'])){
            $year = $_GET['year'];
        }
        
        $month = array();
        $data['yearList'] = $this->transaction->getExpenseYears();

        $expenseList = $this->transaction->getExpenseReport($year);
        if(!empty($expenseList)){
        foreach ($expenseList as $key => $value) {
           $month[$value->name][$value->month] = $value->amount;
        }}
        $data['expenseList'] = $month;
        $data['yearSelected'] = $year;
        // Graph Start
        $graphs = makeExpenseReportGraph($month);
        $data['graph'] = json_encode($graphs);
        // Graph End
        return view('admin.TransactionReport.expense_report', $data);        
    }

    public function incomeReport(){
        $data['menu'] = 'report';
        $data['sub_menu'] = 'transaction/income-report';
        $data['header'] = 'report';
        $year = date('Y');
        if(isset($_GET['year'])){
            $year = $_GET['year'];
        }
        
        $month = array();
        $data['yearList'] = $this->transaction->getIncomeYears();
        
        $expenseList = $this->transaction->getIncomeReport($year);
        if(!empty($expenseList)){
        foreach ($expenseList as $key => $value) {
           $month[$value->name][$value->month] = $value->amount;
        }}

        $data['incomeList'] = $month;
        $data['yearSelected'] = $year;
       
        // Graph Start
        $graphs = makeExpenseReportGraph($month);
        $data['graph'] = json_encode($graphs);
         //d($data,1);
        // Graph End
        return view('admin.TransactionReport.income_report', $data);        
    }


    public function incomeVsExpense(){
    $data['menu'] = 'report';
    $data['sub_menu'] = 'transaction/income-vs-expense';
    $data['header'] = 'report';  
    $data['yearList'] = DB::SELECT("SELECT DISTINCT(YEAR(trans_date)) AS year FROM `bank_trans`");
//d($data['yearList'],1);
    $year = date('Y');
    if(isset($_GET['year'])){
        $year = $_GET['year'];
    }
    $data['yearSelected'] = $year;
    $data['dataList'] = $this->transaction->incomeVsExpense($year);

    return view('admin.TransactionReport.income_vs_expense', $data);   
    }

public function report()
{
    $data['menu'] = 'transaction';
        $data['sub_menu'] = 'transaction/list';
        $data['header'] = 'transaction';
        
        $data['accountList'] = DB::table('bank_accounts')->pluck('account_name','id');
        $data['categoryList'] = DB::table('income_expense_categories')->pluck('name','id');
        $data['types'] = ['income','expense'];
        $data['from'] = $from = date('Y-m-d', strtotime("-30 days"));
        $data['to'] = $to = date('Y-m-d');
        $data['account_no'] = $account_no = NULL;
        $data['category_id'] = $category_id = NULL;
        $data['type_id'] = $type_id = NULL;

        if(isset($_GET['btn'])){
           $data['from'] = $from = $_GET['from'];
           $data['to'] = $to = $_GET['to'];
           $data['account_no'] = $account_no = $_GET['account_no'];
           $data['category_id'] = $category_id = $_GET['category_id'];
           $data['type_id'] = $type_id = $_GET['type'];

        }
        
    $data['transactionList'] = $this->transaction->getAllTransactions($from, $to, $account_no, $category_id, $type_id);
     $pdf = PDF::loadView('admin.TransactionReport.report.transaction_listReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Transações'.time().'.pdf',array("Attachment"=>0));
}
}
