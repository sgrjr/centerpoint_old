<?php namespace App;

class Webdetail extends BaseModel {

	use \App\Ask\AskTrait\DetailTrait;

	protected $fillable = ["INDEX","TESTTRAN","DATE","KEY","REMOTEADDR","ORDEREDBY","REQUESTED","TITLE","ARTICLE","AUTHOR","LASTTOUCH","VISION","PROD_NO","SHIPPED","LISTPRICE","SALEPRICE","DISC","STATUS","ORDERNUM","SUBTITLE","ISSTAND","PUBLISHER","FORMAT","SERIES","SOPLAN","CAT","CATALOG","AUTHORKEY","TITLEKEY","COMPUTER","TIMESTAMP","DATESTAMP","LASTTIME","UNITCOST","PAGES","OUNCES","PUBDATE","INVNATURE","USERPASS","DROPSHIP","EWHERE","ISBN10","ISBN13","EDI","CARTON","SHIPMENT","TRANSNO","LASTDATE"
	];
	protected $table = "webdetails";
	
	protected $appends = [];

    public function getBookConnection(array $record = []){

	    if(empty($record)){
	      $isbn = $this->getAttributes()["PROD_NO"];
	    }else{
	      $isbn = $record["PROD_NO"];
	    }
	    
	    return \App\Inventory::ask()->where("ISBN","===", $isbn)->first();
	  }
}
