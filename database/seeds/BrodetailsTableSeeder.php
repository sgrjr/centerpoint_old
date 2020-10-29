<?php

use Illuminate\Database\Seeder;

class BrodetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Brodetail::seedTable();
    }
}
