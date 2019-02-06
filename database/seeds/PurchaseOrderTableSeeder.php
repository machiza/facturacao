<?php

use Illuminate\Database\Seeder;

class PurchaseOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$purchaseOrder = array(
            array(
                'order_no'=>1,
                'supplier_id'=>1,
                'person_id'=>1,
                'comments'=>'',
                'ord_date'=>date("Y-m-d", strtotime("-82 days")),
                'reference'=>'PO-0001',
                'into_stock_location'=>'PL',
                'total'=>2150000
            ),
            array(
                'order_no'=>2,
                'supplier_id'=>2,
                'person_id'=>1,
                'comments'=>'',
                'ord_date'=>date("Y-m-d", strtotime("-271 days")),
                'reference'=>'PO-0002',
                'into_stock_location'=>'PL',
                'total'=>11500
            ),
            array(
                'order_no'=>3,
                'supplier_id'=>4,
                'person_id'=>1,
                'comments'=>'',
                'ord_date'=>date("Y-m-d", strtotime("-51 days")),
                'reference'=>'PO-0003',
                'into_stock_location'=>'JA',
                'total'=>1656000
            ),
            array(
                'order_no'=>4,
                'supplier_id'=>4,
                'person_id'=>1,
                'comments'=>'',
                'ord_date'=>date("Y-m-d", strtotime("-28 days")),
                'reference'=>'PO-0004',
                'into_stock_location'=>'JA',
                'total'=>5750,
            ),
            array(
                'order_no'=>5,
                'supplier_id'=>4,
                'person_id'=>1,
                'comments'=>'',
                'ord_date'=>date("Y-m-d", strtotime("-22 days")),
                'reference'=>'PO-0005',
                'into_stock_location'=>'JA',
                'total'=>575
            ), 
            array(
                'order_no'=>6,
                'supplier_id'=>1,
                'person_id'=>1,
                'comments'=>'',
                'ord_date'=>date("Y-m-d", strtotime("-7 days")),
                'reference'=>'PO-0006',
                'into_stock_location'=>'JA',
                'total'=>5750,
            ),
            array(
                'order_no'=>7,
                'supplier_id'=>3,
                'person_id'=>1,
                'comments'=>'',
                'ord_date'=>date("Y-m-d", strtotime("-2 days")),
                'reference'=>'PO-0007',
                'into_stock_location'=>'PL',
                'total'=>28750
            )
        );
        DB::table('purch_orders')->truncate();
		DB::table('purch_orders')->insert($purchaseOrder);
    }
}