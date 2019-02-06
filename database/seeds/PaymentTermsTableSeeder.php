<?php

use Illuminate\Database\Seeder;

class PaymentTermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$paymentTerms = [
            array('name' => 'Paypal', 'defaults' => 0),
            array('name' => 'Bank', 'defaults' => 1)
        ];

        DB::table('payment_terms')->truncate();
		DB::table('payment_terms')->insert($paymentTerms);
    }
}