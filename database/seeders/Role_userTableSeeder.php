<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Role_userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\RoleUser::seedTable();
    }
}
