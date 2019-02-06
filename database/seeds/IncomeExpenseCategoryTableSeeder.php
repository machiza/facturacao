<?php

use Illuminate\Database\Seeder;

class IncomeExpenseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	
    $category = [
        ['name' => 'Sales', 'type' => 'income'],
        ['name' => 'Sallery', 'type' => 'income'],
        ['name' => 'Utility Bill', 'type' => 'expense'],
        ['name' => 'Repair & MaintEnance', 'type' => 'expense']        
    ];

        DB::table('income_expense_categories')->truncate();
		DB::table('income_expense_categories')->insert($category);
    }
}