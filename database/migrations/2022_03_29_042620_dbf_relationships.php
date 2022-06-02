<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\DatabaseManager;

class DbfRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $dm = new DatabaseManager();
        $dm->foreignKeysUp();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $dm = new DatabaseManager();
        $db_name = config("database.connections.mysql.database");
        $dm->foreignKeysDown($db_name);
    }
}
