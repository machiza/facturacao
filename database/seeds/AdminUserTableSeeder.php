<?php

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user = array(
                'email'=>'demo@n3.co.mz',
                'password'=>'$2y$10$GbgX0Z2DGHOJIWAkFbkXaOPGH1Fu8QBqktctseholx3RLlKHGM/Y6',
                'real_name'=>'Admin',
                'role_id'=>1,
                'inactive'=>0,
                'remember_token'=>'XbPj4olmc87dlLBoQL2e3v9LJc23EEnoRAI5Pfv8MnGEUFq0ZYpaZAd5JuaW'
        );
        DB::table('users')->truncate();
		DB::table('users')->insert($user);
    }
}