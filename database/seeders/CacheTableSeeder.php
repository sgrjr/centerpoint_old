<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CacheTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Cache::seedTable();
    }
}
