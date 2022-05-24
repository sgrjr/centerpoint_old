<?php namespace App;

class Allhead extends BaseModel {

	use \App\Ask\AskTrait\HeadTrait;
	
	protected $fillable = ["INDEX", "KICKBACK", "INVQUERY", "INVLMNT", "PROMONAME", "MASTERPASS", "MASTERDATE", "DATE", "TESTTRAN", "PO_NUMBER", "TRANSNO", "KEY", "NEWPRODUCT", "TPRODUCT", "PRODUCT", "SHIPPING", "OTHER", "BILL_1", "BILL_2", "BILL_3", "BILL_4", "BILL_5", "SALESTAX", "NEWITEMS", "ITEMS", "TITEMS", "USERPASS", "OTHERDESC", "freeship", "SHIPMETHOD", "COMPANY", "ATTENTION", "STREET", "ROOM", "DEPT", "CITY", "STATE", "POSTCODE", "COUNTRY", "VOICEPHONE", "FAXPHONE", "EMAIL", "sendemconf", "ORDEREDBY", "PINVOICE", "PEPACK", "PIPACK", "PSHIP", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTDATE", "LASTTIME", "REVDATE", "UPS_KEY", "UPSDATE", "BILLWEIGHT", "PACKAGES", "COMMCODE", "OLDCODE", "TERMS", "OSOURCE", "OSOURCE2", "OSOURCE3", "OSOURCE4", "paid", "PAIDAMOUNT", "PAIDDATE", "CHECKDESC", "PAYTYPE", "ONSLIP", "SPECIALD", "REMOTEADDR", "taxexempt", "canbill", "DATEIN", "TIMEIN", "TIMEOUT", "SHIPPER", "SORTORDER", "CXNOTE", "CINOTE", "DATEOUT", "HOTBOX", "ICOLLNOTE", "TRANSNUM", "F997SENT", "F997NUM", "F855SENT", "F855NUM", "F856SENT", "F856NUM", "F810SENT", "F810NUM", "SHIPLABEL", "OSETNUM", "AREVEIW"
];

	protected $table = "allheads";
	protected $appends = [];

	public function getDetailsConnection($record = false){
		if(!$record){		
			return \App\Alldetail::ask()->where("TRANSNO","===", $this->TRANSNO)->get();
		}else{
			$TRANSNO = $record->getObjectByName("TRANSNO");
			return \App\Alldetail::ask()->where("TRANSNO","===", $TRANSNO)->get();
		}
		
	}

	public function getKey(){
		return $this->TRANSNO;
	}

}