<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(KrijoAdminSeed::class);
         $this->call(KrijoPunonjesSeed::class);
         $this->call(KrijoKlientSeed::class);
    }
}
