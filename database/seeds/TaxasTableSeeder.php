<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class TaxasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxas')->insert([
            'id'=>1,
            'data_cambio'=>Carbon::now(),
            'compra'=>1,
            'venda'=>1,
            'moedas_id'=>1, 
            'created_at'=>Carbon::now(),
        ]); 
        DB::table('taxas')->insert([
            'id'=>2,
            'data_cambio'=>Carbon::now(),
            'compra'=>61.2,
            'venda'=>62.42,
            'moedas_id'=>2, 
            'created_at'=>Carbon::now(),
        ]); 
        DB::table('taxas')->insert([
            'id'=>3,
            'data_cambio'=>Carbon::now(),
            'compra'=>69.7,
            'venda'=>71.09,
            'moedas_id'=>3, 
            'created_at'=>Carbon::now(),
        ]); 
        DB::table('taxas')->insert([
            'id'=>4,
            'data_cambio'=>Carbon::now(),
            'compra'=>78.8,
            'venda'=>80.38,
            'moedas_id'=>4, 
            'created_at'=>Carbon::now(),
        ]); 
        DB::table('taxas')->insert([
            'id'=>5,
            'data_cambio'=>Carbon::now(),
            'compra'=>4.39,
            'venda'=>4.48,
            'moedas_id'=>5, 
            'created_at'=>Carbon::now(),
        ]); 
         
    }
}