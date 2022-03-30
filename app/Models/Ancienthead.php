<?php namespace App\Models;
use \App\Traits\DbfTableTrait;
class Ancienthead extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\HeadTrait;
  use DbfTableTrait;

protected $table = "ancientheads";
protected $dbfPrimaryKey = 'TRANSNO';
protected $appends = [];
protected $seed = ['dbf_ancienthead'];
protected $indexes = ["TRANSNO", "KEY"];

 protected $attributeTypes = [ 
  "_config"=>"ancienthead", 
 ];

 protected $ignoreColumns = ["KICKBACK", "INVQUERY", "INVLMNT", "PROMONAME", "TESTTRAN", "NEWPRODUCT", "TPRODUCT", "USERPASS","ORDEREDBY", "PINVOICE", "PEPACK", "PIPACK", "PSHIP", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTDATE", "LASTTIME", "REVDATE", "UPSDATE", "BILLWEIGHT", "PACKAGES", "COMMCODE", "OLDCODE", "OSOURCE2","OSOURCE3", "OSOURCE4", "CHECKDESC", "PAYTYPE", "ONSLIP", "SPECIALD", "REMOTEADDR", "TAXEXEMPT", "CANBILL", "DATEIN", "TIMEIN", "TIMEOUT", "SHIPPER", "SORTORDER", "DATEOUT", "HOTBOX", "TRANSNUM", "F997SENT", "F997NUM", "F855SENT", "F855NUM", "F856SENT", "F856NUM", "F810SENT", "F810NUM", "SHIPLABEL", "OSETNUM", "AREVEIW", "ORSTATUS", "ORSENT", "ORDATE","NEWITEMS","ITEMS","PRODUCT","TITEMS","TERMS","SHIPMETHOD"
 ];

 public function items(){
  return $this->hasMany('\App\Models\Ancientdetail', 'TRANSNO', 'TRANSNO');
 }
}
