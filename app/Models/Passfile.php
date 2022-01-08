<?php namespace App\Models;
use \App\Traits\DbfTableTrait;

class Passfile extends BaseModel implements \App\Interfaces\ModelInterface{

	use DbfTableTrait;
	protected $appends = [];
	protected $table = "passfiles";

	protected $dbfPrimaryKey = 'INDEX';
	protected $seed = ['dbf_passfile'];

      protected $attributeTypes = [ 
        "_config"=>"passfile",
      ];

		public function passfileSchema($table){
		//$table->decimal('discount', 5, 2);
		//$table->decimal('listprice', 5, 2);
		//$table->decimal('saleprice', 5, 2);
		return $table;
	}
}
