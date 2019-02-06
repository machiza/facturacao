<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class GuiaEntrega extends Model
{

    public function getSalseInvoiceByID($id)
    {         $datas = array();
              return    $data = DB::table('sales_ge_details')
                    ->where(['ge_no_id'=>$id])
                    ->leftJoin('item_code', 'sales_ge_details.stock_id', '=', 'item_code.stock_id')
                    ->leftJoin('item_tax_types', 'item_tax_types.id','=','sales_ge_details.tax_type_id')
                    ->select('sales_ge_details.*', 'item_code.id as item_id','item_tax_types.tax_rate')
                    ->orderBy('sales_ge_details.id','ASC')
                    ->get();
      
    }



}
