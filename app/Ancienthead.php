<?php namespace App;
use \App\Core\DbfTableTrait;
class Ancienthead extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\HeadTrait;
    use DbfTableTrait;
    	
	protected $fillable = ["INDEX", "DATE", "KEY", "TRANSNO", "PSHIP", "PEPACK", "PIPACK", "PINVOICE", "NEWITEMS", "NEWPRODUCT", "ITEMS", "PRODUCT", "TITEMS", "USERPASS", "TPRODUCT", "BILL_1", "BILL_2", "BILL_3", "BILL_4", "BILL_5", "SHIPPING", "SALESTAX", "OTHER", "OTHERDESC", "FREESHIP", "SHIPMETHOD", "COMPANY", "ATTENTION", "STREET", "ROOM", "DEPT", "CITY", "STATE", "POSTCODE", "COUNTRY", "VOICEPHONE", "FAXPHONE", "EMAIL", "SENDEMCONF", "ORDEREDBY", "PO_NUMBER", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTDATE", "LASTTIME", "UPS_KEY", "UPSDATE", "BILLWEIGHT", "PACKAGES", "COMMCODE", "TERMS", "OSOURCE", "OSOURCE2", "OSOURCE3", "OSOURCE4", "SORTORDER", "PAID", "PAIDAMOUNT", "PAIDDATE", "PAYTYPE", "SPECIALD", "REMOTEADDR", "TAXEMPT", "CANBIL", "DATEIN", "TIMEIN", "DATEOUT", "TIMEOUT", "SHIPPER", "CXNOTE", "CINOTE", "HOTBOX", "ICOLLNOTE", "F810SENT", "F855SENT", "F856SENT", "CHECKDESC"
];

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
