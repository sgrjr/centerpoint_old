<?php namespace App;
use \App\Core\DbfTableTrait;
class Backhead extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\HeadTrait;
    use DbfTableTrait;

	protected $table = "backheads";
	protected $appends = [];

	protected $dbfPrimaryKey = 'TRANSNO';
	  protected $seed = [
    'dbf_backhead'
  ];
      protected $attributeTypes = [ 
        "_config"=>"backhead",
      ];	

  public function items(){
    return $this->hasMany('\App\Backdetail','TRANSNO','TRANSNO');
  }
}
