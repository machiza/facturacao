<?php

use Illuminate\Database\Seeder;

class SalesOrderDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$salesOrderDetails = array(
            array(
                'id'=>1,
                'order_no'=>1,
                'trans_type'=>201,
                'stock_id'=>'APPLE',
                'tax_type_id'=>2,
                'description'=>'Iphone 7+',
                'unit_price'=>160,
                'qty_sent'=>0,
                'quantity'=>500,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>2,
                'order_no'=>2,
                'trans_type'=>201,
                'stock_id'=>'LENEVO',
                'tax_type_id'=>2,
                'description'=>'LED TV',
                'unit_price'=>700,
                'qty_sent'=>0,
                'quantity'=>100,
                'is_inventory'=>1,
                'discount_percent'=>0
            ), 
            array(
                'id'=>3,
                'order_no'=>3,
                'trans_type'=>201,
                'stock_id'=>'WALTON',
                'tax_type_id'=>2,
                'description'=>'Walton Primo GH',
                'unit_price'=>90,
                'qty_sent'=>0,
                'quantity'=>10,
                'is_inventory'=>1,
                'discount_percent'=>0
            ), 
            array(
                'id'=>4,
                'order_no'=>4,
                'trans_type'=>202,
                'stock_id'=>'WALTON',
                'tax_type_id'=>2,
                'description'=>'Walton Primo GH',
                'unit_price'=>90,
                'qty_sent'=>0,
                'quantity'=>10,
                'is_inventory'=>1,
                'discount_percent'=>0
            ), 
            array(
                'id'=>5,
                'order_no'=>3,
                'trans_type'=>201,
                'stock_id'=>'APPLE',
                'tax_type_id'=>2,
                'description'=>'Iphone 7+',
                'unit_price'=>160,
                'qty_sent'=>0,
                'quantity'=>10,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>6,
                'order_no'=>4,
                'trans_type'=>202,
                'stock_id'=>'APPLE',
                'tax_type_id'=>2,
                'description'=>'Iphone 7+',
                'unit_price'=>160,
                'qty_sent'=>0,
                'quantity'=>10,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>7,
                'order_no'=>3,
                'trans_type'=>201,
                'stock_id'=>'SAMSUNG',
                'tax_type_id'=>2,
                'description'=>'Samsung G7',
                'unit_price'=>90,
                'qty_sent'=>0,
                'quantity'=>10,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>8,
                'order_no'=>4,
                'trans_type'=>201,
                'stock_id'=>'SAMSUNG',
                'tax_type_id'=>2,
                'description'=>'Samsung G7',
                'unit_price'=>90,
                'qty_sent'=>0,
                'quantity'=>10,
                'is_inventory'=>1,
                'discount_percent'=>0
            ), 
            array(
                'id'=>9,
                'order_no'=>5,
                'trans_type'=>201,
                'stock_id'=>'SONY',
                'tax_type_id'=>2,
                'description'=>'Sony experia 5',
                'unit_price'=>90,
                'qty_sent'=>0,
                'quantity'=>50,
                'is_inventory'=>1,
                'discount_percent'=>0
            ), 
            array(
                'id'=>10,
                'order_no'=>6,
                'trans_type'=>202,
                'stock_id'=>'SONY',
                'tax_type_id'=>2,
                'description'=>'Sony experia 5',
                'unit_price'=>90,
                'qty_sent'=>0,
                'quantity'=>50,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>11,
                'order_no'=>5,
                'trans_type'=>201,
                'stock_id'=>'LG',
                'tax_type_id'=>2,
                'description'=>'LG Refrigeretor',
                'unit_price'=>80,
                'qty_sent'=>0,
                'quantity'=>70,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>12,
                'order_no'=>6,
                'trans_type'=>202,
                'stock_id'=>'LG',
                'tax_type_id'=>2,
                'description'=>'LG Refrigeretor',
                'unit_price'=>80,
                'qty_sent'=>0,
                'quantity'=>70,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>13,
                'order_no'=>7,
                'trans_type'=>202,
                'stock_id'=>'APPLE',
                'tax_type_id'=>2,
                'description'=>'Iphone 7+',
                'unit_price'=>160,
                'qty_sent'=>0,
                'quantity'=>5000,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>14,
                'order_no'=>8,
                'trans_type'=>201,
                'stock_id'=>'SAMSUNG',
                'tax_type_id'=>2,
                'description'=>'Samsung G7',
                'unit_price'=>90,
                'qty_sent'=>0,
                'quantity'=>100,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>15,
                'order_no'=>9,
                'trans_type'=>202,
                'stock_id'=>'SAMSUNG',
                'tax_type_id'=>2,
                'description'=>'Samsung G7',
                'unit_price'=>90,
                'qty_sent'=>0,
                'quantity'=>100,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>16,
                'order_no'=>10,
                'trans_type'=>201,
                'stock_id'=>'LG',
                'tax_type_id'=>2,
                'description'=>'LG Refrigeretor',
                'unit_price'=>80,
                'qty_sent'=>0,
                'quantity'=>100,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>17,
                'order_no'=>11,
                'trans_type'=>202,
                'stock_id'=>'LG',
                'tax_type_id'=>2,
                'description'=>'LG Refrigeretor',
                'unit_price'=>80,
                'qty_sent'=>0,
                'quantity'=>1000,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>18,
                'order_no'=>11,
                'trans_type'=>202,
                'stock_id'=>'SAMSUN',
                'tax_type_id'=>2,
                'description'=>'Samsung G7',
                'unit_price'=>90000,
                'qty_sent'=>0,
                'quantity'=>1000,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>19,
                'order_no'=>12,
                'trans_type'=>201,
                'stock_id'=>'APPLE',
                'tax_type_id'=>2,
                'description'=>'Iphone 7+',
                'unit_price'=>50000,
                'qty_sent'=>0,
                'quantity'=>50,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
            array(
                'id'=>20,
                'order_no'=>13,
                'trans_type'=>202,
                'stock_id'=>'APPLE',
                'tax_type_id'=>2,
                'description'=>'Iphone 7+',
                'unit_price'=>50000,
                'qty_sent'=>0,
                'quantity'=>50,
                'is_inventory'=>1,
                'discount_percent'=>0
            ),
        );
        DB::table('sales_order_details')->truncate();
		DB::table('sales_order_details')->insert($salesOrderDetails);
    }
}