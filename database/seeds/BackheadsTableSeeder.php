<?php

use Illuminate\Database\Seeder;

class BackheadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Backhead::seedTable();
    }
}
