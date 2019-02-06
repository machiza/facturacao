<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{

    public function getAccounts()
    { 
        $data = DB::select("select ba.*, bat.name as account_type, SUM(bt.amount) as balance from bank_accounts as ba
                LEFT JOIN bank_trans as bt
                  ON ba.id = bt.account_no
                LEFT JOIN bank_account_type as bat
                  ON bat.id = ba.account_type_id
                where ba.deleted = 0
                GROUP BY bt.account_no
                ORDER BY ba.account_name ASC
                ");
        return $data;
    }
}
