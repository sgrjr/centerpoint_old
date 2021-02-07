<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BooktextsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Booktext::seedTable();
    }
}
