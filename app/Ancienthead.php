<?php namespace App;

class Ancienthead extends BaseModel {

	use \App\Ask\AskTrait\HeadTrait;
	
	protected $fillable = ["INDEX", "DATE", "KEY", "TRANSNO", "PSHIP", "PEPACK", "PIPACK", "PINVOICE", "NEWITEMS", "NEWPRODUCT", "ITEMS", "PRODUCT", "TITEMS", "USERPASS", "TPRODUCT", "BILL_1", "BILL_2", "BILL_3", "BILL_4", "BILL_5", "SHIPPING", "SALESTAX", "OTHER", "OTHERDESC", "freeship", "SHIPMETHOD", "COMPANY", "ATTENTION", "STREET", "ROOM", "DEPT", "CITY", "STATE", "POSTCODE", "COUNTRY", "VOICEPHONE", "FAXPHONE", "EMAIL", "sendemconf", "ORDEREDBY", "PO_NUMBER", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTDATE", "LASTTIME", "UPS_KEY", "UPSDATE", "BILLWEIGHT", "PACKAGES", "COMMCODE", "TERMS", "OSOURCE", "OSOURCE2", "OSOURCE3", "OSOURCE4", "SORTORDER", "paid", "PAIDAMOUNT", "PAIDDATE", "PAYTYPE", "SPECIALD", "REMOTEADDR", "taxexempt", "canbill", "DATEIN", "TIMEIN", "DATEOUT", "TIMEOUT", "SHIPPER", "CXNOTE", "CINOTE", "HOTBOX", "ICOLLNOTE", "F810SENT", "F855SENT", "F856SENT", "CHECKDESC"
];

	protected $table = "ancientheads";
	//protected $primaryKey = 'KEY';

	protected $appends = [];
	public function getDetailsConnection($record = false){
		if(!$record){		
			return \App\Ancientdetail::ask()->where("TRANSNO","===", $this->TRANSNO)->get();
		}else{
			$TRANSNO = $record->getObjectByName("TRANSNO");
			return \App\Ancientdetail::ask()->where("TRANSNO","===", $TRANSNO)->get();
		}
	}

	public function getKey(){
		return $this->TRANSNO;
	}
}
