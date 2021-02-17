<?php namespace App;
use \App\Core\DbfTableTrait;

class Allhead extends BaseModel implements \App\Interfaces\ModelInterface{

	use \App\Ask\AskTrait\HeadTrait;
    use DbfTableTrait;
    	
	protected $table = "allheads";
	protected $appends = [];

	protected $seed = [
		'dbf_allhead'
	];
	protected $dbfPrimaryKey = 'TRANSNO';
    protected $attributeTypes = [ 
        "_config"=>"allhead",
      ];

  public function items(){
    return $this->hasMany('\App\Alldetail','TRANSNO','TRANSNO');
  }

}