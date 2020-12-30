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

	public function getDetailsConnection($record = false){
		if(!$record){		
			return \App\BackDetail::ask()->where("TRANSNO","===", $this->TRANSNO)->get();
		}else{
			$TRANSNO = $record->getObjectByName("TRANSNO");
			return \App\BackDetail::ask()->where("TRANSNO","===", $TRANSNO)->get();
		}
		
	}

	public function backheadSchema($table){ 
		//$table->unique('transno'); 
		return $table;
	}
	
}
