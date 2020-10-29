<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAncientHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    private function getTable(){
        $table = new \App\Ancienthead();
        return $table;
    }

    public function up()
    {
        $this->getTable()->createTable();   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $t = $this->getTable();

        $name = $t->getTable();

        if(Schema::hasTable($name)){
            $t->dropTable();
        }

    }
}
