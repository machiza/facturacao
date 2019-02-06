<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$currency = [
            'name' => 'Metical',
            'symbol' => 'Mt',
        ];
        DB::table('currency')->truncate();
		DB::table('currency')->insert($currency);
    }
}