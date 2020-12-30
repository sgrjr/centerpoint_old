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

	public function getDetailsConnection($record = false){
		if(!$record){		
			return \App\AncientDetail::ask()->where("TRANSNO","===", $this->TRANSNO)->get();
		}else{
			$TRANSNO = $record->getObjectByName("TRANSNO");
			return \App\AncientDetail::ask()->where("TRANSNO","===", $TRANSNO)->get();
		}
	}

	public function ancientheadSchema($table){ $table->unique('TRANSNO'); return $table;	}
}
