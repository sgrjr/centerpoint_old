<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\DatabaseManager;

class Dbfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $dm = new DatabaseManager();

        $shouldBeSeeded = false;
        $dm->rebuildAllDbfTables($shouldBeSeeded);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $dm = new DatabaseManager();
        $dm->dropAllTables();
    }
}
