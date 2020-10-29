<?php

use Illuminate\Database\Seeder;

class OrderitemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\OrderItem::seedTable();
    }
}
