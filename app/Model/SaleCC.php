<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;


class SaleCC extends Model
{
    protected $table = 'sales_cc';
   
   
        public function getSaleYears(){
        $data = DB::select("SELECT DISTINCT YEAR(ord_date) as year FROM sales_orders WHERE trans_type = 202  ORDER BY ord_date DESC");
        return $data;
    }


}
