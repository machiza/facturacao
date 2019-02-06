<?php

use Illuminate\Database\Seeder;

class MonthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$months = array(
            array(
                'name'=>'January'
            ),
            array(
                'name'=>'February'
            ),
            array(
                'name'=>'March'
            ),
            array(
                'name'=>'Appril'
            ),
            array(
                'name'=>'May'
            ),
            array(
                'name'=>'June'
            ),                                                            
            array(
                'name'=>'July'
            ),
            array(
                'name'=>'August'
            ),
            array(
                'name'=>'September'
            ),
            array(
                'name'=>'October'
            ),
            array(
                'name'=>'November'
            ),
            array(
                'name'=>'December'
            )             
        );
        DB::table('months')->truncate();
		DB::table('months')->insert($months);
    }
}