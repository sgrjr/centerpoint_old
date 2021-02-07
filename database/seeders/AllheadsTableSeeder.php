<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AllheadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Allhead::seedTable();
    }
}
