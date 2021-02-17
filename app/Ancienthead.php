<?php namespace App;
use \App\Core\DbfTableTrait;
class Ancienthead extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\HeadTrait;
    use DbfTableTrait;

	protected $table = "ancientheads";

	protected $dbfPrimaryKey = 'TRANSNO';

	protected $appends = [];
	  protected $seed = [
    'dbf_ancienthead'
  ];

      protected $attributeTypes = [ 
        "_config"=>"ancienthead",
      ];

  public function items(){
    return $this->hasMany('\App\Ancientdetail','TRANSNO','TRANSNO');
  }
}
