<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $dm = new \App\Helpers\DatabaseManager();
        $opt = new \stdclass;
        $opt->name = "ALL";
        $opt->overwrite = false;
        $dm->seedTable($opt);
    }
}
