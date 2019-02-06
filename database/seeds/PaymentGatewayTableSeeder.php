<?php

use Illuminate\Database\Seeder;

class PaymentGatewayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$paymentTerms = [
            array('name' => 'username','value'=>'techvillage_business_api1.gmail.com','site'=>'PayPal'),
            array('name' => 'password','value'=>'9DDYZX2JLA6QL668','site'=>'PayPal'),
            array('name' => 'signature','value'=>'AFcWxV21C7fd0v3bYYYRCpSSRl31ABayz5pdk84jno7.Udj6-U8ffwbT','site'=>'PayPal'),
            array('name' => 'mode','value'=>'sandbox','site'=>'PayPal'),                        
        ];

        DB::table('payment_gateway')->truncate();
		DB::table('payment_gateway')->insert($paymentTerms);
    }
}