<?php namespace App;
use \App\Core\DbfTableTrait;

class Allhead extends BaseModel implements \App\Interfaces\ModelInterface{

	use \App\Ask\AskTrait\HeadTrait;
    use DbfTableTrait;
    	
	protected $fillable = ["INDEX", "KICKBACK", "INVQUERY", "INVLMNT", "PROMONAME", "MASTERPASS", "MASTERDATE", "DATE", "TESTTRAN", "PO_NUMBER", "TRANSNO", "KEY", "NEWPRODUCT", "TPRODUCT", "PRODUCT", "SHIPPING", "OTHER", "BILL_1", "BILL_2", "BILL_3", "BILL_4", "BILL_5", "SALESTAX", "NEWITEMS", "ITEMS", "TITEMS", "USERPASS", "OTHERDESC", "FREESHIP", "SHIPMETHOD", "COMPANY", "ATTENTION", "STREET", "ROOM", "DEPT", "CITY", "STATE", "POSTCODE", "COUNTRY", "VOICEPHONE", "FAXPHONE", "EMAIL", "SENDEMCONF", "ORDEREDBY", "PINVOICE", "PEPACK", "PIPACK", "PSHIP", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTDATE", "LASTTIME", "REVDATE", "UPS_KEY", "UPSDATE", "BILLWEIGHT", "PACKAGES", "COMMCODE", "OLDCODE", "TERMS", "OSOURCE", "OSOURCE2", "OSOURCE3", "OSOURCE4", "PAID", "PAIDAMOUNT", "PAIDDATE", "CHECKDESC", "PAYTYPE", "ONSLIP", "SPECIALD", "REMOTEADDR", "TAXEMPT", "CANBILL", "DATEIN", "TIMEIN", "TIMEOUT", "SHIPPER", "SORTORDER", "CXNOTE", "CINOTE", "DATEOUT", "HOTBOX", "ICOLLNOTE", "TRANSNUM", "F997SENT", "F997NUM", "F855SENT", "F855NUM", "F856SENT", "F856NUM", "F810SENT", "F810NUM", "SHIPLABEL", "OSETNUM", "AREVEIW"
];

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