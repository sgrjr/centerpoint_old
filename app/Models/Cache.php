<?php namespace App\Models;

class Cache extends BaseModel implements \App\Models\Interfaces\ModelInterface 
{	

	protected $fillable = ["key","value","expiration"];
	protected $table = "cache";
	protected $appends = [];	
  
    protected $seed = [];

    protected $attributeTypes = [
        "key"=>[
            "name" => "key",
            "type" => "String",
            "length" => 255
           ],
       "value"=>[
            "name" => "value",
            "type" => "LongText",
            "length" => null
           ],
       "expiration"=>[
            "name" => "expiration",
            "type" => "Int",
            "length" => 30
           ],
        "timestamps" => true
      ];

    public function schema($table){
      	$table->string('key')->unique();
		$table->longText('value');
		$table->integer('expiration');
        return $table;
     }
}
