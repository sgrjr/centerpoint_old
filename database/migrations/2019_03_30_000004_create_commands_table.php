<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	 
	public function up()
    {
		$dbf = new \App\Models\Command;
		$dbf->createTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('commands');
    }
}
