<?php

use Illuminate\Database\Seeder;

class EmailConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		/*$emailConfig = [
            'email_protocol' => 'smtp',
            'email_encryption' => 'tls',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_email' => 'stockpile.techvill@gmail.com',
            'smtp_username' =>'stockpile.techvill@gmail.com',
            'smtp_password' =>'xgldhlpedszmglvj',
            'from_address' =>'stockpile.techvill@gmail.com',
            'from_name' => 'stockpile.techvill@gmail.com',
        ];*/
        $emailConfig = [
            'email_protocol' => 'smtp',
            'email_encryption' => 'tls',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_email' => 'n3facturacao@gmail.com',
            'smtp_username' =>'n3facturacao@gmail.com',
            'smtp_password' =>'facturacao@2018',
            'from_address' =>'n3facturacao@gmail.com',
            'from_name' => 'n3facturacao@gmail.com',
        ];
        DB::table('email_config')->truncate();
		DB::table('email_config')->insert($emailConfig);
    }
}