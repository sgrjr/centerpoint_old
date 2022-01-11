<?php namespace App\Models;
use Schema;
use App\Models\Dbf\DBaseHandler;
use App\Models\Dbf\PHPXbase\XBaseTable;
use App\Helpers\Compare;

class Dbf extends BaseModel implements \App\Interfaces\ModelInterface {

	protected $fillable = ["source","name","memo","model","updated_at","created_at"];
	public $timestamps = true;
	protected $dates = ['created_at', 'updated_at'];
	protected $table = "dbfs";
	protected $appends = ["properties"];
	
	protected $seed = [];
     protected $indexes = [];

 	protected $attributeTypes = [
        "source"=>[
            "name" => "source",
            "type" => "String",
            "length" => 255
           ],
       "name"=>[
            "name" => "name",
            "type" => "String",
            "length" => 255,
            "unique" => true
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

}