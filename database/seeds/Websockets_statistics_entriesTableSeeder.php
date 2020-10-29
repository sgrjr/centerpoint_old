<?php

use Illuminate\Database\Seeder;

class Websockets_statistics_entriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\WebSocketStatistic::seedTable();
    }
}
