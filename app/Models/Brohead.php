<?php namespace App\Models;
use \App\Models\Traits\DbfTableTrait;
class Brohead extends BaseModel implements \App\Models\Interfaces\ModelInterface {
	
	use \App\Ask\AskTrait\HeadTrait;
    use DbfTableTrait;
    
	protected $appends = [];
	protected $table = "broheads";	

	protected $dbfPrimaryKey = 'TRANSNO';
	protected $seed = [
    	'dbf_brohead'
  	];
  	 protected $indexes = ["TRANSNO", "KEY"];

      protected $attributeTypes = [ 
        "_config"=>"brohead",
      ];

  public function items(){
    return $this->hasMany('\App\Models\Brodetail','TRANSNO','TRANSNO');
  }
}
