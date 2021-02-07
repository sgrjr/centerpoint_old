<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DbfsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Dbf::seedTable();
    }
}
