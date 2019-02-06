<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class VD extends Model
{
    //
        public function getSalseInvoiceByID($id)
    {         $datas = array();
              return    $data = DB::table('sales_details_vd')
                    ->leftJoin('item_code', 'sales_details_vd.stock_id', '=', 'item_code.stock_id')
                    ->leftJoin('item_tax_types', 'item_tax_types.id','=','sales_details_vd.tax_type_id')
                    ->select('sales_details_vd.*', 'item_code.id as item_id','item_tax_types.tax_rate')
                    ->where('vd_no','=',$id)
                    ->orderBy('sales_details_vd.id','ASC')
                    ->get();
      
    }



}
