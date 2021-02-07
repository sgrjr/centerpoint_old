<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Standing_ordersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\StandingOrder::seedTable();
    }
}
