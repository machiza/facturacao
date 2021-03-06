<?php

use Illuminate\Database\Seeder;

class SalesPriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$salesPrices = array(
            array(
                'stock_id'=>'APPLE',
                'sales_type_id'=>1,
                'curr_abrev'=>'USD',
                'price'=>160
            ),
            array(
                'stock_id'=>'HP',
                'sales_type_id'=>1,
                'curr_abrev'=>'USD',
                'price'=>120
            ),
            array(
                'stock_id'=>'LENEVO',
                'sales_type_id'=>1,
                'curr_abrev'=>'USD',
                'price'=>70
            ),
            array(
                'stock_id'=>'LG',
                'sales_type_id'=>1,
                'curr_abrev'=>'USD',
                'price'=>80
            ),
            array(
                'stock_id'=>'SAMSUNG',
                'sales_type_id'=>1,
                'curr_abrev'=>'USD',
                'price'=>90
            ),
            array(
                'stock_id'=>'SINGER',
                'sales_type_id'=>1,
                'curr_abrev'=>'USD',
                'price'=>80
            ),
            array(
                'stock_id'=>'SONY',
                'sales_type_id'=>1,
                'curr_abrev'=>'USD',
                'price'=>90
            ),
            array(
                'stock_id'=>'WALTON',
                'sales_type_id'=>1,
                'curr_abrev'=>'USD',
                'price'=>85
            )
        );
        DB::table('sale_prices')->truncate();
		DB::table('sale_prices')->insert($salesPrices);
    }
}