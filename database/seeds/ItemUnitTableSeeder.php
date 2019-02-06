<?php

use Illuminate\Database\Seeder;

class ItemUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$itemUnit = [
            'abbr' => 'each',
            'name' => 'Each'
        ];

        DB::table('item_unit')->truncate();
		DB::table('item_unit')->insert($itemUnit);
    }
}