<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AncientdetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Ancientdetail::seedTable();
    }
}
