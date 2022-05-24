<?php namespace App;

use Auth, Event, Schema, stdClass;
use  Illuminate\Database\Schema\Blueprint;

class Command extends BaseModel {

	protected $fillable = ["id","command","options","updated_at","created_at","user_id"];
	protected $table = "commands";
	protected $appends = [];	


public function createTable(){

	 Schema::create('commands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('command');
            $table->string('options');
            $table->timestamps();

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
 }

}