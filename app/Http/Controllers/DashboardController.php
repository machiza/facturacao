<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Start\Helpers;
use App\Http\Requests;
use DB;
use session;
use App\Model\Report;
use App\Model\Transaction;
use App\Model\Bank;

class DashboardController extends Controller
{
    public function __construct(Report $report, Transaction $transaction, Bank $bank){
        $this->report = $report;
        $this->transaction = $transaction;
        $this->bank = $bank;
    }
    
	protected $data = [];

    /**
     * Display a listing of the Over All Information on Dashboard.
     *
     * @return Dashboard page view
     */
	
    public function index()
    {   
      $data['menu'] = 'dashboard';

        $thirtyDaysNameList  = thirtyDaysNameList();
        
        $lastThirtyDaysIncomes = $this->transaction->lastThirtyDaysIncomes();
        $lastThirtyDaysExpenses = $this->transaction->lastThirtyDaysExpenses();
        $lastThirtyDaysProfit  = lastThirtyDaysProfit($lastThirtyDaysIncomes,$lastThirtyDaysExpenses);

        // Get list of order to invoice
        
        $data['incomesArray'] = json_encode($lastThirtyDaysIncomes);
        $data['expenseArray'] = json_encode($lastThirtyDaysExpenses);
        $data['thirtyDayprofit'] = json_encode($lastThirtyDaysProfit);
      	
        $data['date']   =  json_encode($thirtyDaysNameList);
        
        $data['startDate'] = formatDate(date("d-m-Y", strtotime ("-30 day",strtotime(date('d-m-Y') ))));

        $data['endDate']   = formatDate(date("d-m-Y"));

        // Income
        $openInvoice = $this->transaction->getOpenInvoiceAmount();
        $overDueAmount = $this->transaction->overDueAmount();
        $paidAmount = $this->transaction->lastThirtyDaysPaymentAmount();
        $data['openInvoice']   = $openInvoice; 
        $data['overDue']   = $overDueAmount;
        $data['paidAmount']    = $paidAmount;

        // Expense By Category
        $data['expenseAmount'] = $this->transaction->lastThirtyDaysExpenseAmount();
       // d($data['expenseAmount'],1);
        $data['expenseAmountCategory'] = $expenseCategories = $this->transaction->expenseAmountByCategory();
        $categoryArray = [];       
      if(!empty($expenseCategories)){
        
        $colors = ['#DD4B39','#00A65A','#F39C12','#00C0EF','#3C8DBC','#E5FFFF'];
        $otherAmount = 0 ;
        foreach ($expenseCategories as $key => $value) {
          if($key<=4){
            $categoryArray[$key]['value'] = (int)$value->amount;
            $categoryArray[$key]['color'] = $colors[$key];
            $categoryArray[$key]['highlight'] = $colors[$key];
            $categoryArray[$key]['label'] = $value->name;
          }
          if($key>4){
            $otherAmount += $value->amount;
          }

        }

          $categoryArray[5]['value'] = (int)$otherAmount;
          $categoryArray[5]['color'] = '#E5FFFF';
          $categoryArray[5]['highlight'] = '#E5FFFF';
          $categoryArray[5]['label'] = 'Others';       

      }
        $data['expenseGraph'] = json_encode($categoryArray);

        // Income and Expense
        $data['totalIncome'] = abs($this->transaction->getTotalIncome());
        $data['totalExpense'] = abs($this->transaction->getTotalExpense());

        $getLastSixMonthName = getLastSixMonthName();
        $getLastSixMonthNumber = getLastSixMonthNumber();
        $sixMonthExpense = $this->transaction->getsixMonthExpense();
        $sixMonthIncome = $this->transaction->getsixMonthIncome();
        $expenseArrayList = getExpenseArrayList($sixMonthExpense,$getLastSixMonthNumber);
        $incomeArrayList = getExpenseArrayList($sixMonthIncome,$getLastSixMonthNumber);

        $profitArrayList = getProfitArrayList($expenseArrayList,$incomeArrayList);
        
        $expenses = [];
        foreach ($expenseArrayList as $key => $expenseItem) {
          $expenses[$key] = (int)$expenseItem['amount'];
        }

        $incomes = [];
        foreach ($incomeArrayList as $key => $incomeItem) {
          $incomes[$key] = abs((int)$incomeItem['amount']);
        }


        $data['profitArr'] = json_encode($profitArrayList);
        $data['expensesArr'] = json_encode($expenses);
        $data['incomeArr'] = json_encode($incomes);
        $data['sixMonth'] = json_encode($getLastSixMonthName);
        // Bank Account List 
        $data['accountList'] = $this->bank->getAccounts();
        $data['latestIncomeList'] = $this->transaction->latestIncomeList();
        $data['latestIncomeExpenses'] = $this->transaction->latestIncomeExpenses();
       //d($data,1);
        return view('admin.dashboard', $data);
    }

    /**
     * Change Language function
     *
     * @return true or false
     */

    public function switchLanguage(Request $request)
    {
        
        if ($request->lang) {
            \Session::put('dflt_lang', $request->lang);
            //\DB::table('preference')->where('id', 1)->update(['value' => $request->lang]);
            \App::setLocale($request->lang);
            echo 1;
        } else {
            echo 0;
        }

    }
}
