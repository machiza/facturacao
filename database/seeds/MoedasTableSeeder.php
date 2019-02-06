<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class MoedasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('moedas')->insert([
            'id'=>1,
            'nome'=>'MZN',
            'singular'=>'Metical',
            'plural'=>'Meticais',
            'casas_decimais_sing'=>'Centavo',
            'casas_decimais_plu'=>'Centavos',
            'created_at'=>Carbon::now(),
        ]);  
        DB::table('moedas')->insert([
            'id'=>2,
            'nome'=>'USD',
            'singular'=>'Dollar',
            'plural'=>'Dollars',
            'casas_decimais_sing'=>'Cêntimo',
            'casas_decimais_plu'=>'Cêntimos',
            'created_at'=>Carbon::now(),
        ]); 
        DB::table('moedas')->insert([
            'id'=>3,
            'nome'=>'EUR',
            'singular'=>'Euro',
            'plural'=>'Euros',
            'casas_decimais_sing'=>'Cêntimo',
            'casas_decimais_plu'=>'Cêntimos',
            'created_at'=>Carbon::now(),
        ]); 
        DB::table('moedas')->insert([
            'id'=>4,
            'nome'=>'GBP',
            'singular'=>'Libra',
            'plural'=>'Libras',
            'casas_decimais_sing'=>'Cêntimo',
            'casas_decimais_plu'=>'Cêntimos',
            'created_at'=>Carbon::now(),
        ]); 
        DB::table('moedas')->insert([
            'id'=>5,
            'nome'=>'ZAR',
            'singular'=>'Rand',
            'plural'=>'Rands',
            'casas_decimais_sing'=>'Cêntimo',
            'casas_decimais_plu'=>'Cêntimos',
            'created_at'=>Carbon::now(),
        ]);  
    }
}