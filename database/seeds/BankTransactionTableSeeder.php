<?php

use Illuminate\Database\Seeder;

class BankTransactionTableSeeder extends Seeder
{
    public function run()
    {
		$transcations = array(
            array(
                'id'=>1,
                'amount'=>1000,
                'trans_type'=>'cash-in',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d"),
                'person_id'=>1,
                'reference'=>'opening balance',
                'description'=>'opening balance',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'id'=>2,
                'amount'=>5000,
                'trans_type'=>'cash-in',
                'account_no'=>2,
                'trans_date'=>date("Y-m-d"),
                'person_id'=>1,
                'reference'=>'opening balance',
                'description'=>'opening balance',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'id'=>3,
                'amount'=>10000,
                'trans_type'=>'cash-in',
                'account_no'=>3,
                'trans_date'=>date("Y-m-d"),
                'person_id'=>1,
                'reference'=>'opening balance',
                'description'=>'opening balance',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s")
            ),            
            array(
                'id'=>4,
                'amount'=>50000,
                'trans_type'=>'deposit',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d", strtotime("-25 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Deposit',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s",strtotime("-25 days"))
            ),
            array(
                'id'=>5,
                'amount'=>35000,
                'trans_type'=>'deposit',
                'account_no'=>2,
                'trans_date'=>date("Y-m-d", strtotime("-22 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Deposit',
                'category_id'=>2,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-22 days"))
            ),
            array(
                'id'=>6,
                'amount'=>60000,
                'trans_type'=>'deposit',
                'account_no'=>3,
                'trans_date'=>date("Y-m-d", strtotime("-7 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Deposit',
                'category_id'=>1,
                'payment_method'=>2,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-7 days"))
            ),
            array(
                'id'=>7,
                'amount'=>500,
                'trans_type'=>'deposit',
                'account_no'=>2,
                'trans_date'=>date("Y-m-d", strtotime("-12 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Deposit',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-12 days"))
            ),
            array(
                'id'=>8,
                'amount'=>40000,
                'trans_type'=>'deposit',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d"),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Deposit',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'id'=>9,
                'amount'=>5000,
                'trans_type'=>'deposit',
                'account_no'=>3,
                'trans_date'=>date("Y-m-d", strtotime("-100 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Doposit',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-100 days"))
            ), 
            array(
                'id'=>10,
                'amount'=>-45000,
                'trans_type'=>'expense',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d", strtotime("-127 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Expense',
                'category_id'=>4,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-127 days"))
            ),
            array(
                'id'=>11,
                'amount'=>-40000,
                'trans_type'=>'expense',
                'account_no'=>2,
                'trans_date'=>date("Y-m-d", strtotime("-25 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Expense',
                'category_id'=>3,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-25 days"))
            ),
            array(
                'id'=>12,
                'amount'=>-35000,
                'trans_type'=>'expense',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d", strtotime("-6 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Expense',
                'category_id'=>3,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-6 days"))
            ),
            array(
                'id'=>13,
                'amount'=>-3000,
                'trans_type'=>'expense',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d", strtotime("-2 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Expense',
                'category_id'=>3,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-2 days"))
            ),
            array(
                'id'=>14,
                'amount'=>25000,
                'trans_type'=>'deposit',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d", strtotime("-12 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Deposit',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-12 days"))
            ),
            array(
                'id'=>15,
                'amount'=>-5000,
                'trans_type'=>'expense',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d", strtotime("-12 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Expense',
                'category_id'=>3,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-12 days"))
            ),
            array(
                'id'=>16,
                'amount'=>60000,
                'trans_type'=>'deposit',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d", strtotime("-112 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'New Deposit',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-112 days"))
            ),
            array(
                'id'=>17,
                'amount'=>615,
                'trans_type'=>'cash-in-by-sale',
                'account_no'=>2,
                'trans_date'=>date("Y-m-d"),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'Payment for INV-0002',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'id'=>18,
                'amount'=>500,
                'trans_type'=>'cash-in-by-sale',
                'account_no'=>1,
                'trans_date'=>date("Y-m-d", strtotime("-5 days")),
                'person_id'=>1,
                'reference'=>'',
                'description'=>'Payment for INV-0003',
                'category_id'=>1,
                'payment_method'=>1,
                'attachment'=>'',
                'created_at'=>date("Y-m-d H:i:s", strtotime("-5 days"))
            )

        );
        DB::table('bank_trans')->truncate();
		DB::table('bank_trans')->insert($transcations);
    }
}