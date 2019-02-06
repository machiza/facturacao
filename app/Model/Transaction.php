<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    public function getAllTransactions($from, $to, $account_no, $category_id, $type)
    { 
          $from = DbDateFormat($from);
          $to = DbDateFormat($to);

          $where ="bt.trans_date BETWEEN '$from' AND '$to' AND bt.trans_type !='cash-in' ";
          
          if($account_no){
            $where .= " AND bt.account_no = '$account_no' ";   
          }
          if($category_id){
            $where .= " AND bt.category_id = '$category_id' "; 
          }

          if($type){
            if($type == 'income'){
              $where .= " AND bt.trans_type IN ('deposit','cash-in-by-sale')"; 
            }elseif($type == 'expense'){
              $where .= " AND bt.trans_type IN ('expense')"; 
            }
          }

          $data = DB::SELECT("SELECT bt.*, ba.account_name,ba.account_no,iec.name as category FROM bank_trans as bt
          LEFT JOIN bank_accounts as ba
          ON bt.account_no = ba.id
          LEFT JOIN income_expense_categories as iec 
          ON bt.category_id = iec.id
          WHERE $where
          ORDER BY bt.created_at DESC");

          return $data;

    }

    public function getAllTransfers()
    { 
          $data = DB::table('bank_trans')
                  ->where('trans_type','cash-out-by-transfer')
                  ->orWhere('trans_type','cash-in-by-transfer')
                  ->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_trans.account_no')
                  ->select('bank_trans.*','bank_accounts.account_name')
                  ->orderBy('bank_trans.created_at','DESC')
                  ->get();     

          return $data;
    }

    public function getExpenseReport($year){

      $data = DB::select("SELECT bt.*,iec.name FROM(SELECT category_id,month(trans_date) AS month,SUM(amount) as amount from bank_trans WHERE YEAR(trans_date)=$year GROUP BY month, category_id)bt RIGHT JOIN(SELECT * FROM income_expense_categories WHERE type NOT IN ('income'))iec ON bt.category_id = iec.id");
      
      return $data;
    }

    public function getIncomeReport($year){

      $data = DB::select("SELECT bt.*,iec.name FROM(SELECT category_id,month(trans_date) AS month,SUM(amount) as amount from bank_trans WHERE YEAR(trans_date)=$year GROUP BY month, category_id)bt RIGHT JOIN(SELECT * FROM income_expense_categories WHERE type IN ('income'))iec ON bt.category_id = iec.id");
      
      return $data;
    }


    public function getExpenseYears(){
      $year = array();
      $data = DB::select("SELECT DISTINCT(bt.year) FROM(SELECT category_id,year(trans_date)as year from bank_trans)bt RIGHT JOIN(SELECT * FROM income_expense_categories WHERE type NOT IN ('income'))iec ON bt.category_id = iec.id ");
      
      if(!empty($data)){
      foreach ($data as $key => $value) {
        if(!empty($value->year)){
        $year[$key] = $value->year;
       }
      }}

      return $year;
    }

    public function getIncomeYears(){
      $year = array();
      $data = DB::select("SELECT DISTINCT(bt.year) FROM(SELECT category_id,year(trans_date)as year from bank_trans)bt RIGHT JOIN(SELECT * FROM income_expense_categories WHERE type IN ('income'))iec ON bt.category_id = iec.id");
      
      if(!empty($data)){
      foreach ($data as $key => $value) {
        if(!empty($value->year)){
        $year[$key] = $value->year;
       }
      }}

      return $year;
    }

    public function getOpenInvoiceAmount(){
      $amount = 0;
      $invoicedAmount = DB::table('sales_orders')
            ->where('order_reference', '!=', NULL)
            ->sum('total');
      $paidAmount = DB::table('payment_history')->sum('amount');

      $amount = ($invoicedAmount-$paidAmount);

      return $amount;
    }

    public function lastThirtyDaysPaymentAmount(){
      $amount = 0;
      $today = date('Y-m-d H:i:s');
      $preDay = date('Y-m-d H:i:s', strtotime("-30 days"));
      
      $paidAmount = DB::select("SELECT SUM(amount) as amount FROM payment_history WHERE payment_date BETWEEN '$preDay' AND '$today'");
      if(!empty($paidAmount[0]->amount) ){
        $amount = $paidAmount[0]->amount;
      }
      return $amount;
    }

    public function overDueAmount(){
      $amount = 0;
      $today =date('Y-m-d');
      $paidAmounts = DB::select("SELECT so.ord_date, DATE_ADD(so.ord_date, INTERVAL ipt.days_before_due DAY) as due_date, so.total, so.paid_amount FROM sales_orders as so
        LEFT JOIN invoice_payment_terms as ipt
          ON ipt.id = so.payment_term
        WHERE so.order_reference_id != 0");

      if(!empty($paidAmounts)){
        foreach ($paidAmounts as $value) {
          if($value->due_date<$today){
          $due = ($value->total-$value->paid_amount);
          $amount += $due;
         }
        }
      }
 
      return $amount;
    }

    public function lastThirtyDaysExpenseAmount(){
      $amount = 0;
      $today = date('Y-m-d H:i:s');
      $preDay = date('Y-m-d H:i:s', strtotime("-30 days"));
      $expenseAmount = DB::select("SELECT SUM(amount) as amount FROM bank_trans WHERE created_at BETWEEN '$preDay' AND '$today' AND trans_type='expense'");

      if(!empty($expenseAmount[0]->amount) ){
        $amount = abs($expenseAmount[0]->amount);
      }

      return $amount;
    }

    public function expenseAmountByCategory(){
        $data = DB::select("SELECT bt.category_id, iec.name, SUM(ABS(bt.amount)) as amount FROM `bank_trans` as bt
          LEFT JOIN income_expense_categories as iec
          ON iec.id = bt.category_id
          WHERE bt.trans_type = 'expense'
          GROUP BY bt.category_id
          ORDER BY amount DESC
          ");

        return $data;
    }

    public function getTotalIncome(){
      $data = DB::table('bank_trans')
              ->where('trans_type','deposit')
              ->orWhere('trans_type','cash-in-by-sale')
              ->sum('amount');
      return $data;
    }

    public function getTotalExpense(){
      $data = DB::table('bank_trans')
              ->where('trans_type','expense')
              ->sum('amount');
      return $data;
    }

    public function getsixMonthExpense(){
      $today = date('Y-m-d');
      $previousDate = previousDate();

      $data = DB::select("SELECT SUM(amount) as amount,month,year FROM(SELECT amount,trans_date,MONTH(trans_date) as month,YEAR(trans_date) as year  FROM bank_trans 
        WHERE trans_date BETWEEN '$previousDate' AND '$today' AND trans_type = 'expense')expense GROUP BY month,year");
        return $data;     
    }
    public function getsixMonthIncome(){
      $today = date('Y-m-d');
      $previousDate = previousDate();
      
     $data = DB::select("SELECT SUM(amount) as amount,month,year FROM(SELECT amount,trans_date,MONTH(trans_date) as month,YEAR(trans_date) as year  FROM bank_trans 
        WHERE trans_date BETWEEN '$previousDate' AND '$today' AND trans_type IN ('deposit','cash-in-by-sale'))income GROUP BY month,year");
        return $data;    
    }

    public function lastThirtyDaysIncomes(){
      $getLastOneMonthDates = getLastOneMonthDates();
      $final = [];
      $data_map = array();
      $today = date('Y-m-d');
      $previousDate = date("Y-m-d", strtotime ("-30 day",strtotime(date('d-m-Y') )));
      
      $data = DB::select("SELECT SUM(amount) as amount,trans_date,MONTH(trans_date) as month,DAY(trans_date) as day FROM bank_trans WHERE trans_date BETWEEN '$previousDate' AND '$today' AND trans_type IN ('deposit','cash-in-by-sale') GROUP BY trans_date");

      if(!empty($data)){
        foreach ($data as $key => $value) {
         $data_map[$value->day][$value->month] = abs($value->amount);
        }

        $dataArray = [];
        $i = 0;
        foreach ($getLastOneMonthDates as $key => $value) {
          $date = explode('-', $value);
          $td = (int) $date[0];
          $tm = (int) $date[1];
          $dataArray[$i]['day'] =  $date[0];
          $dataArray[$i]['month'] =  $date[1];
          if(isset($data_map[$td][$tm])) {
            $dataArray[$i]['amount'] =  abs($data_map[$td][$tm]);
          }else{
            $dataArray[$i]['amount'] =  0;
         }
          $i++;
        }

        
        foreach($dataArray as $key=>$res){
          $final[$key] = abs($res['amount']);
        }

      }
      return $final;
    }
    public function lastThirtyDaysExpenses(){
      $getLastOneMonthDates = getLastOneMonthDates();
       $final = [];
      $data_map = array();
      $today = date('Y-m-d');
      $previousDate = date("Y-m-d", strtotime ("-30 day",strtotime(date('d-m-Y') )));
      
      $data = DB::select("SELECT SUM(amount) as amount,trans_date,MONTH(trans_date) as month,DAY(trans_date) as day FROM bank_trans WHERE trans_date BETWEEN '$previousDate' AND '$today' AND trans_type IN ('expense') GROUP BY trans_date");

      if(!empty($data)){
        foreach ($data as $key => $value) {
         $data_map[$value->day][$value->month] = abs($value->amount);
        }

        $dataArray = [];
        $i = 0;
        foreach ($getLastOneMonthDates as $key => $value) {
          $date = explode('-', $value);
          $td = (int) $date[0];
          $tm = (int) $date[1];
          $dataArray[$i]['day'] =  $date[0];
          $dataArray[$i]['month'] =  $date[1];
          if(isset($data_map[$td][$tm])) {
            $dataArray[$i]['amount'] =  $data_map[$td][$tm];
          }else{
            $dataArray[$i]['amount'] =  0;
         }
          $i++;
        }

       
        foreach($dataArray as $key=>$res){
          $final[$key] = $res['amount'];
        }

      }
      return $final;
    }

    public function latestIncomeList(){
      $data = DB::table('bank_trans')
            ->where('trans_type','deposit')
            ->orWhere('trans_type','  cash-in-by-sale')
            ->orderBy('id','DESC')
            ->take(5)
            ->get();
      return $data;
    }
    public function latestIncomeExpenses(){
      $data = DB::table('bank_trans')
            ->where('trans_type','expense')
            ->orderBy('id','DESC')
            ->take(5)
            ->get();
      return $data;
    }

  public function getTransactionByAccountId($startDate, $endDate, $account_id)
  {
      
      $data = DB::select("SELECT * FROM bank_trans 
        WHERE trans_date 
        BETWEEN '$startDate' AND '$endDate' AND account_no = $account_id ORDER BY trans_date DESC");
      $amount = DB::select("SELECT SUM(amount) as amount FROM bank_trans 
        WHERE trans_date<'$startDate' 
        AND account_no = $account_id");
      $dataArray['amount'] = isset($amount[0]->amount) ? $amount[0]->amount : 0;
      $dataArray['result'] = $data;

      return $dataArray;
   
  }

  public function incomeVsExpense($year){
    $data = [];
    $income_map = [];
    $expense_map = [];
    $incomeFinal = [];
    $expenseFinal = [];
    $finalArray = [];
    $monthList = DB::table('months')->pluck('name','id');
   // Income Start
    $incomeArray = DB::SELECT("SELECT month(trans_date) AS month,SUM(amount) as amount from bank_trans WHERE trans_type IN ('deposit','cash-in-by-sale') AND YEAR(trans_date)='$year' GROUP BY month");

    foreach($incomeArray as $key => $income){
      $income_map[$income->month] = $income->amount;
    }
    $counter = 0;
    foreach ($monthList as $i => $month) {
     if(isset($income_map[$i])){
      $incomeFinal[$counter]['amount'] = $income_map[$i];
      $incomeFinal[$counter]['month'] = $month;
     }else{
      $incomeFinal[$counter]['amount'] = 0;
      $incomeFinal[$counter]['month'] = $month;
     }
     $counter++;
    }
    
   
   // Expense Start
    $expenseArray = DB::SELECT("SELECT month(trans_date) AS month,SUM(amount) as amount from bank_trans WHERE trans_type IN ('expense') AND YEAR(trans_date)='$year' GROUP BY month");

    foreach($expenseArray as $expense){
      $expense_map[$expense->month] = $expense->amount;
    }
    $count = 0;
    foreach ($monthList as $index => $month) {
     if(isset($expense_map[$index])){
      $expenseFinal[$count]['amount'] = abs($expense_map[$index]);
      $expenseFinal[$count]['month'] = $month;
     }else{
      $expenseFinal[$count]['amount'] = 0;
      $expenseFinal[$count]['month'] = $month;
     }
     $count++;
    }
// Profit calcualtion
  for($row=0;$row<=11;$row++){
    $finalArray[$row]['month'] = $expenseFinal[$row]['month'];
    $finalArray[$row]['income'] = $incomeFinal[$row]['amount'];
    $finalArray[$row]['expense'] = $expenseFinal[$row]['amount'];
    $finalArray[$row]['profit'] = ($incomeFinal[$row]['amount'] - $expenseFinal[$row]['amount']); 
  }
    return $finalArray;
  }

}
