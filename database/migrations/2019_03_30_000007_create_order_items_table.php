<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
 {
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
    {
		$model = new \App\OrderItem;
		$model->createTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		$model = new \App\OrderItem;
        Schema::drop($model->getTableName());
    }
}
