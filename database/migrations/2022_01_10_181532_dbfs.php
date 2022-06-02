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
        $db_name = config("database.connections.mysql.database");
        $dm->rebuildAllDbfTables($db_name, $shouldBeSeeded);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $db_name = config("database.connections.mysql.database");
        \App\Helpers\DatabaseManager::dropDatabaseIfExists($db_name);
    }
}
