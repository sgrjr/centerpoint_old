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
            /*7*/'\Database\Seeders\BackheadsTableSeeder',
            /*8*/'\Database\Seeders\BackdetailsTableSeeder', //16 secs
            /*9*/'\Database\Seeders\BroheadsTableSeeder', //5 secs
            /*10*/'\Database\Seeders\BrodetailsTableSeeder',
            /*11*/'\Database\Seeders\BooktextsTableSeeder',
            /*12*/'\Database\Seeders\CommandsTableSeeder',
            /*13*/'\Database\Seeders\CompaniesTableSeeder',
            /*14*/'\Database\Seeders\DbfsTableSeeder',
            /*15*/'\Database\Seeders\PassfilesTableSeeder',
            /*16*/'\Database\Seeders\Standing_ordersTableSeeder', //76seconds
            /*17*///'\Database\Seeders\AllheadsTableSeeder', //18 minutes
            /*18*///'\Database\Seeders\AlldetailsTableSeeder',//33 m
            /*19*///'\Database\Seeders\AncientheadsTableSeeder', //33 m
            /*20*///'\Database\Seeders\AncientdetailsTableSeeder' //103 minutes
        ];

        $this->call($list);

    }
}
