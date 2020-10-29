<?php

use Illuminate\Database\Seeder;

class AlldetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Alldetail::seedTable();
    }
}
