<?php namespace App\Models;
use \App\Traits\DbfTableTrait;

class Passfile extends BaseModel implements \App\Interfaces\ModelInterface{

	use DbfTableTrait;

	protected $table = "passfiles";
	protected $appends = [];
	protected $seed = ['dbf_passfile'];
	protected $dbfPrimaryKey = 'INDEX';
	public $timestamps = false;
  protected $attributeTypes = [ 
    "_config"=>"passfile",
  ];
  //protected $ignoreColumns = ["DUNNDAYS"];
  //public $fillable = ["INDEX","DELETED"];
}
