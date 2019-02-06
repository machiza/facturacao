<?php

use Illuminate\Database\Seeder;

class BankAccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$accounts = array(
            array(
                'account_type_id'=>1,
                'account_name'=>'John Bradon',
                'account_no'=>100001,
                'bank_name'=>'Bank of America Corp',
                'bank_address'=>'USA',
                'deleted'=>0,
                'default_account'=>1
            ),array(
                'account_type_id'=>3,
                'account_name'=>'Michle Harry',
                'account_no'=>200001,
                'bank_name'=>'JPMorgan Chase & Co',
                'bank_address'=>'USA',
                'deleted'=>0,
                'default_account'=>0
            ),array(
                'account_type_id'=>4,
                'account_name'=>'Mr. Russell',
                'account_no'=>300001,
                'bank_name'=>'Bank of America',
                'bank_address'=>'USA',
                'deleted'=>0,
                'default_account'=>0
            )

        );
        DB::table('bank_accounts')->truncate();
		DB::table('bank_accounts')->insert($accounts);
    }
}