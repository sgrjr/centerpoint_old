<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Order_itemsTableSeeder extends Seeder
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
