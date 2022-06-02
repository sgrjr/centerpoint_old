<?php namespace App\Models;

use Auth, Event, Schema, stdClass;
use  Illuminate\Database\Schema\Blueprint;

class Command extends BaseModel implements \App\Interfaces\ModelInterface {

	protected $fillable = ["command","options","updated_at","created_at","user_id"];
	protected $table = "commands";
	protected $appends = [];	
  
    protected $seed = [];

    public function schema($table){
        $table->string('command');
        $table->string('options');
        $table->timestamps();
        $table->unsignedInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users');
        return $table;
     }

}