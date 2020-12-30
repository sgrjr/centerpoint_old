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

	public function getDetailsConnection($record = false){
		if(!$record){		
			return \App\BroDetail::ask()->where("TRANSNO","===", $this->TRANSNO)->get();
		}else{
			$TRANSNO = $record->getObjectByName("TRANSNO");
			return \App\BroDetail::ask()->where("TRANSNO","===", $TRANSNO)->get();
		}
		
	}

	public function broheadSchema($table){$table->unique('TRANSNO'); return $table;}
}
