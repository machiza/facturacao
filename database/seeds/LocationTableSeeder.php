<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$location = [
            ['loc_code' => 'A1','location_name' => 'Armazem 1', 'delivery_address' => 'Armazem 1','contact' => 'Armazem 1', 'created_at' => date('Y-m-d H:i:s')],
            ['loc_code' => 'A2','location_name' => 'Armazem 2', 'delivery_address' => 'Armazem 2','contact' => 'Armazem 2', 'created_at' => date('Y-m-d H:i:s')]            
        ];
        DB::table('location')->truncate();
		DB::table('location')->insert($location);
    }
}