<?php namespace App;
use \App\Core\DbfTableTrait;
class Brohead extends BaseModel implements \App\Interfaces\ModelInterface {
	
	use \App\Ask\AskTrait\HeadTrait;
    use DbfTableTrait;
    
	protected $appends = [];
	protected $table = "broheads";	

	protected $dbfPrimaryKey = 'TRANSNO';
	protected $seed = [
    	'dbf_brohead'
  	];

      protected $attributeTypes = [ 
        "_config"=>"brohead",
      ];

  public function items(){
    return $this->hasMany('\App\Brodetail','TRANSNO','TRANSNO');
  }
}
