<?php namespace App;
use \App\Core\DbfTableTrait;

class Passfile extends BaseModel implements \App\Interfaces\ModelInterface{

	use DbfTableTrait;

	protected $fillable = ["INDEX","KEY","DUNNDAYS","COMPANY","ORGNAME","EMAIL","STANDING","COUNTRY","LISTPRICE","SALEPRICE","WEBSERVER","PASSWORD","DATE","WHATCOLOR","VISION","DISCOUNT"];
	protected $appends = [];
	protected $table = "passfiles";
<<<<<<< HEAD
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
=======
	//protected $primaryKey = 'REMOTEADDR';
}
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
