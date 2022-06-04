<?php namespace App\Models;

class TableUpdate extends BaseModel implements \App\Models\Interfaces\ModelInterface {

      public $timestamps = false;
      protected $fillable = ['class','table','watch','sources','updates','pending'];
  
      protected $table = "tableupdates";

      protected $seed = [];

    protected $attributeTypes = [
        "name"=>[
            "name" => "name",
            "type" => "Char",
            "length" => 128
           ]
      ];
   
	
}
