<?php

use Illuminate\Database\Seeder;

class OrderCustomItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('custom_item_orders')->truncate();
		//DB::table('custom_item_orders')->insert($orders);
    }
}