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
}
