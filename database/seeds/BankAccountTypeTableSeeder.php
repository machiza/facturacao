<?php

use Illuminate\Database\Seeder;

class BankAccountTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
		$accountType = array(
            array(
                'name'=>'Savings Account',
            ),array(
                'name'=>'Chequing Account',
            ),array(
                'name'=>'Credit Account',
            ),array(
                'name'=>'Cash Account',
            )
        );
        DB::table('bank_account_type')->truncate();
		DB::table('bank_account_type')->insert($accountType);
    }
}