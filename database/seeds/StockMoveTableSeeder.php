<?php

use Illuminate\Database\Seeder;

class StockMoveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$stockMoves = array(
            array(
                'trans_id'=>1,
                'stock_id'=>'WALTON',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-82 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_1',
                'transaction_reference_id'=>1,
                'qty'=>5000
            ),
            array(
                'trans_id'=>2,
                'stock_id'=>'SONY',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-82 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_1',
                'transaction_reference_id'=>1,
                'qty'=>5000
            ),
            array(
                'trans_id'=>3,
                'stock_id'=>'SAMSUN',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-82 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_1',
                'transaction_reference_id'=>1,
                'qty'=>5000
            ),
            array(
                'trans_id'=>4,
                'stock_id'=>'LG',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-82 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_1',
                'transaction_reference_id'=>1,
                'qty'=>5000
            ),
            array(
                'trans_id'=>5,
                'stock_id'=>'LENEVO',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-82 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_1',
                'transaction_reference_id'=>1,
                'qty'=>5000
            ), 
            array(
                'trans_id'=>6,
                'stock_id'=>'APPLE',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-82 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_1',
                'transaction_reference_id'=>1,
                'qty'=>5000
            ),  
            array(
                'trans_id'=>7,
                'stock_id'=>'HP',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-82 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_1',
                'transaction_reference_id'=>1,
                'qty'=>5000
            ), 
            array(
                'trans_id'=>8,
                'stock_id'=>'APPLE',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-281 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_2',
                'transaction_reference_id'=>2,
                'qty'=>100
            ),
            array(
                'trans_id'=>9,
                'stock_id'=>'WALTON',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_3',
                'transaction_reference_id'=>3,
                'qty'=>3000
            ),
            array(
                'trans_id'=>10,
                'stock_id'=>'SONY',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_3',
                'transaction_reference_id'=>3,
                'qty'=>3000
            ),
            array(
                'trans_id'=>11,
                'stock_id'=>'SINGER',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_3',
                'transaction_reference_id'=>3,
                'qty'=>3000
            ),
            array(
                'trans_id'=>12,
                'stock_id'=>'SAMSUN',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-82 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_3',
                'transaction_reference_id'=>3,
                'qty'=>3000
            ),
            array(
                'trans_id'=>13,
                'stock_id'=>'LG',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-82 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_3',
                'transaction_reference_id'=>3,
                'qty'=>3000
            ),
            array(
                'trans_id'=>14,
                'stock_id'=>'LENEVO',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_3',
                'transaction_reference_id'=>3,
                'qty'=>3000
            ), 
            array(
                'trans_id'=>15,
                'stock_id'=>'HP',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_3',
                'transaction_reference_id'=>3,
                'qty'=>3000
            ),  
            array(
                'trans_id'=>16,
                'stock_id'=>'APPLE',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_3',
                'transaction_reference_id'=>3,
                'qty'=>3000
            ),
            array(
                'trans_id'=>17,
                'stock_id'=>'SAMSUN',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_4',
                'transaction_reference_id'=>4,
                'qty'=>100
            ),
            array(
                'trans_id'=>18,
                'stock_id'=>'SINGER',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_5',
                'transaction_reference_id'=>5,
                'qty'=>10
            ),
            array(
                'trans_id'=>19,
                'stock_id'=>'LENEVO',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_6',
                'transaction_reference_id'=>6,
                'qty'=>100
            ),  
            array(
                'trans_id'=>20,
                'stock_id'=>'SAMSUN',
                'order_no'=>0,
                'trans_type'=>102,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'',
                'reference'=>'store_in_7',
                'transaction_reference_id'=>7,
                'qty'=>500
            ), 
            array(
                'trans_id'=>21,
                'stock_id'=>'WALTON',
                'order_no'=>3,
                'trans_type'=>202,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0003',
                'reference'=>'store_out_4',
                'transaction_reference_id'=>4,
                'qty'=>-10
            ),
            array(
                'trans_id'=>22,
                'stock_id'=>'APPLE',
                'order_no'=>3,
                'trans_type'=>202,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0003',
                'reference'=>'store_out_4',
                'transaction_reference_id'=>4,
                'qty'=>-10
            ), 
            array(
                'trans_id'=>23,
                'stock_id'=>'SAMSUN',
                'order_no'=>3,
                'trans_type'=>202,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0003',
                'reference'=>'store_out_4',
                'transaction_reference_id'=>4,
                'qty'=>-10
            ), 
            array(
                'trans_id'=>24,
                'stock_id'=>'SONY',
                'order_no'=>5,
                'trans_type'=>202,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0004',
                'reference'=>'store_out_6',
                'transaction_reference_id'=>6,
                'qty'=>-50
            ), 
            array(
                'trans_id'=>25,
                'stock_id'=>'LG',
                'order_no'=>5,
                'trans_type'=>202,
                'loc_code'=>'JA',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0004',
                'reference'=>'store_out_6',
                'transaction_reference_id'=>6,
                'qty'=>-70
            ),
            array(
                'trans_id'=>26,
                'stock_id'=>'APPLE',
                'order_no'=>1,
                'trans_type'=>202,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0001',
                'reference'=>'store_out_7',
                'transaction_reference_id'=>7,
                'qty'=>-5000
            ),
            array(
                'trans_id'=>27,
                'stock_id'=>'SAMSUN',
                'order_no'=>8,
                'trans_type'=>202,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0005',
                'reference'=>'store_out_9',
                'transaction_reference_id'=>9,
                'qty'=>-100
            ),
            array(
                'trans_id'=>28,
                'stock_id'=>'LG',
                'order_no'=>10,
                'trans_type'=>202,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0006',
                'reference'=>'store_out_11',
                'transaction_reference_id'=>11,
                'qty'=>-1000
            ),
            array(
                'trans_id'=>29,
                'stock_id'=>'SAMSUN',
                'order_no'=>10,
                'trans_type'=>202,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-50 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0005',
                'reference'=>'store_out_11',
                'transaction_reference_id'=>11,
                'qty'=>-1000
            ),
            array(
                'trans_id'=>30,
                'stock_id'=>'APPLE',
                'order_no'=>12,
                'trans_type'=>202,
                'loc_code'=>'PL',
                'tran_date'=>date("Y-m-d", strtotime("-21 days")),
                'person_id'=>1,
                'order_reference'=>'SO-0007',
                'reference'=>'store_out_13',
                'transaction_reference_id'=>13,
                'qty'=>-50
            )

        );
        DB::table('stock_moves')->truncate();
		DB::table('stock_moves')->insert($stockMoves);
    }
}