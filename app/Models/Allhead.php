<?php namespace App\Models;
use \App\Models\Traits\DbfTableTrait;

class Allhead extends BaseModel implements \App\Models\Interfaces\ModelInterface{

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

      protected $indexes = ["TRANSNO", "KEY"];

 protected $ignoreColumns = [
"KICKBACK","INVQUERY","INVLMNT","PROMONAME","MASTERPASS","MASTERDATE","TESTTRAN","NEWPRODUCT","TPRODUCT","PRODUCT","SALESTAX","NEWITEMS","ITEMS","TITEMS","USERPASS","OTHERDESC","SHIPMETHOD","ORDEREDBY","PINVOICE","PEPACK","PIPACK","PSHIP","COMPUTER","TIMESTAMP","DATESTAMP","LASTTOUCH","LASTDATE","LASTTIME","REVDATE","OSOURCE2","OSOURCE3","OSOURCE4","CHECKDESC","PAYTYPE","ONSLIP","SPECIALD","REMOTEADDR","TAXEXEMPT","CANBILL","DATEIN","TIMEIN","TIMEOUT","SHIPPER","SORTORDER","DATEOUT","HOTBOX","TRANSNUM","F997SENT","F997NUM","F855SENT","F855NUM","F856SENT","F856NUM","F810SENT","F810NUM","SHIPLABEL","OSETNUM","AREVEIW","ORSTATUS","ORSENT","ORDATE","BILLWEIGHT","PACKAGES","OLDCODE","DELETED"
 ];

  public function items(){
    return $this->hasMany('\App\Models\Alldetail','TRANSNO','TRANSNO');
  }

}