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

	public function getDetailsConnection($record = false){
		if(!$record){		
			return \App\AllDetail::ask()->where("TRANSNO","===", $this->TRANSNO)->get();
		}else{
			$TRANSNO = $record->getObjectByName("TRANSNO");
			return \App\AllDetail::ask()->where("TRANSNO","===", $TRANSNO)->get();
		}
		
	}

	public function allheadSchema($table){ $table->unique('TRANSNO'); return $table;	}

}