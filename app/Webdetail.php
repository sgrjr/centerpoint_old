<?php namespace App;
use \App\Core\DbfTableTrait;
class Webdetail extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\DetailTrait;
    use DbfTableTrait;
   
	protected $table = "webdetails";

	  protected $seed = [
    'dbf_webdetail'
  ];

	protected $appends = [];
      protected $attributeTypes = [ 
        "_config"=>"webdetail",
      ];
    public function getBookConnection(array $record = []){

	    if(empty($record)){
	      $isbn = $this->getAttributes()["PROD_NO"];
	    }else{
	      $isbn = $record["PROD_NO"];
	    }
	    
	    return \App\Inventory::ask()->where("ISBN","===", $isbn)->first();
	  }

	  	public function webdetailSchema($table){$table->foreign('REMOTEADDR')->references('REMOTEADDR')->on('webheads'); return $table;	}

	  	public function getCartAttribute(){
	  		return \App\WebHead::dbf()
                  ->where("REMOTEADDR", "==", $this->REMOTEADDR)
                  ->first();
	  	}

}
