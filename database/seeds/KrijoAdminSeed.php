<?php

use App\Http\Controllers\Classes\LoginClass;
use Illuminate\Database\Seeder;

class KrijoAdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(LoginClass::TABLE_NAME)->insert([
            'username' => 'admin',
            'password' => '87d9bb400c0634691f0e3baaf1e2fd0d',
            'role' => 1,
        ]);

        DB::table(LoginClass::TABLE_NAME)->insert([
            'username' => 'user',
            'password' => '87d9bb400c0634691f0e3baaf1e2fd0d',
            'role' => 2,
        ]);
        DB::table(LoginClass::TABLE_NAME)->insert([
            'username' => 'klient',
            'password' => '87d9bb400c0634691f0e3baaf1e2fd0d',
            'role' => 3,
        ]);
    }
}
