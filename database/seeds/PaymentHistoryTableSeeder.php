<?php

use Illuminate\Database\Seeder;

class PaymentHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$paymentHistory = array(
            array(
                'transaction_id'=>17,
                'payment_type_id'=>1,
                'order_reference'=>'SO-0004',
                'invoice_reference'=>'INV-0002',
                'payment_date'=>date('Y-m-d'),
                'amount'=>615,
                'person_id'=>1,
                'customer_id'=>2,
                'reference'=>'',
                'created_at'=>date('Y-m-d H:i:s')
            ),
            array(
                'transaction_id'=>18,
                'payment_type_id'=>1,
                'order_reference'=>'SO-0001',
                'invoice_reference'=>'INV-0003',
                'payment_date'=>date('Y-m-d', strtotime("-5 days")),
                'amount'=>500,
                'person_id'=>1,
                'customer_id'=>1,
                'reference'=>'',
                'created_at'=>date('Y-m-d H:i:s', strtotime("-5 days"))
            )

        );
        DB::table('payment_history')->truncate();
		DB::table('payment_history')->insert($paymentHistory);
    }
}