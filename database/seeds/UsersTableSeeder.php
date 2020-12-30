<?php

use Illuminate\Database\Seeder;
use App\Table;
use App\DatabaseManager;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::seedTable();
    }

}
