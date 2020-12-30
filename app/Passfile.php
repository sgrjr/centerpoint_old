<?php namespace App;
use \App\Core\DbfTableTrait;

class Passfile extends BaseModel implements \App\Interfaces\ModelInterface{

	use DbfTableTrait;

	protected $fillable = ["INDEX","KEY","DUNNDAYS","COMPANY","ORGNAME","EMAIL","STANDING","COUNTRY","LISTPRICE","SALEPRICE","WEBSERVER","PASSWORD","DATE","WHATCOLOR","VISION","DISCOUNT"];
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
