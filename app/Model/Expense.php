<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    public function getAllExpenses()
    { 
          $data = DB::table('bank_trans')
          			->leftJoin('bank_accounts', 'bank_accounts.id', '=', 'bank_trans.account_no' )
          			->where('trans_type','expense')
          			->select('bank_trans.*','bank_accounts.account_name')
          			->orderBy('bank_trans.created_at','DESC')
          			->get();
          return $data;
    }


}
