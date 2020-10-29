<?php namespace App;
use Schema;
use App\DBF\DBaseHandler;
use App\DBF\PHPXbase\XBaseTable;
use App\Helpers\Compare;

class Dbf extends BaseModel implements \App\Interfaces\ModelInterface {

	protected $fillable = ["source","name","memo","model","updated_at","created_at"];
	public $timestamps = true;
	protected $dates = ['created_at', 'updated_at'];
	protected $table = "dbfs";
	protected $appends = ["properties"];
	
	protected $seed = [];

 	protected $attributeTypes = [
        "source"=>[
            "name" => "source",
            "type" => "String",
            "length" => 255
           ],
       "name"=>[
            "name" => "name",
            "type" => "String",
            "length" => 255
           ],
       "memo"=>[
            "name" => "memo",
            "type" => "String",
            "length" => 255
           ],
       "model"=>[
            "name" => "model",
            "type" => "String",
            "length" => 255
           ],
        "timestamps" => true
      ];


	public function schema($table){
		$table->string('name')->unique();
		$table->string('source');
		$table->text('memo');
		$table->string('model');
		$table->timestamps();
		return $table;
	}

}
