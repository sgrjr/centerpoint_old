<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    
        //9:54 start
        //10:05 users fini
        //10:06 allheads start
        //
        $list = [
            /*0*/'\Database\Seeders\UsersTableSeeder', //11.5 minutes
            /*1*/'\Database\Seeders\RolesTableSeeder',
            /*2*/'\Database\Seeders\Role_userTableSeeder',
            /*3*/'\Database\Seeders\InventoriesTableSeeder',
            /*4*/'\Database\Seeders\VendorsTableSeeder',
            /*5*/'\Database\Seeders\WebheadsTableSeeder',
            /*6*/'\Database\Seeders\WebdetailsTableSeeder',
            /*7*/'\Database\Seeders\AllheadsTableSeeder', //3.6 minutes
            /*8*/'\Database\Seeders\AlldetailsTableSeeder',//14 m
            /*9*/'\Database\Seeders\AncientheadsTableSeeder',
            /*10*/'\Database\Seeders\AncientdetailsTableSeeder',
            /*11*/'\Database\Seeders\BackheadsTableSeeder',
            /*12*/'\Database\Seeders\BackdetailsTableSeeder',
            /*13*/'\Database\Seeders\BroheadsTableSeeder',
            /*14*/'\Database\Seeders\BrodetailsTableSeeder',
            /*15*/'\Database\Seeders\BooktextsTableSeeder',
            /*16*/'\Database\Seeders\CommandsTableSeeder',
            /*17*/'\Database\Seeders\CompaniesTableSeeder',
            /*18*/'\Database\Seeders\DbfsTableSeeder',
            /*19*/'\Database\Seeders\PassfilesTableSeeder',
            /*20*/'\Database\Seeders\Standing_ordersTableSeeder'
        ];

        $this->call($list);

    }
}
