<?php

use Illuminate\Database\Seeder;

class BroheadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Brohead::seedTable();
    }
}
