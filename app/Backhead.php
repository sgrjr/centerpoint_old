<?php namespace App;

class Backhead extends BaseModel {

	use \App\Ask\AskTrait\HeadTrait;

	protected $fillable = ["INDEX","KICKBACK","INVQUERY","INVLMNT","PROMONAME","MASTERPASS","MASTERDATE","OSOURCE","SHIPLABEL","TESTTRAN","DATE","KEY","TRANSNO","USERPASS","PO_NUMBER","ITEMS","NEWITEMS","TITEMS","BITEMS","PRODUCT","NEWPRODUCT","TPRODUCT","BPRODUCT","SHIPPING","SALESTAX","OTHER","OTHERDESC","FREESHIP","SHIPMETHOD","BILL_1","BILL_2","BILL_3","BILL_4","BILL_5","COMPANY","ATTENTION","STREET","ROOM","DEPT","CITY","STATE","POSTCODE","COUNTRY","VOICEPHONE","FAXPHONE","EMAIL","SENDEMCONF","ORDEREDBY","PSHIP","PINVOICE","PIPACK","PEPACK","COMPUTER","TIMESTAMP","DATESTAMP","LASTTOUCH","LASTDATE","LASTTIME","UPS_KEY","BILLWEIGHT","PACKAGES","COMMCODE","TERMS","OSOURCE2","OSOURCE3","OSOURCE4","PAID","PAIDAMOUNT","PAIDDATE","PAYTYPE","SPECIALD","REMOTEADDR","TAXEXEMPT","CANBILL","SORTORDER","CXNOTE","CINOTE","HOTBOX","SHIPPER","DATEIN","TIMEIN","DATEOUT","TIMEOUT","F997SENT","F997NUM","F855SENT","F855NUM","TRANSNUM","OSETNUM"
];

	protected $table = "backheads";
	protected $appends = [];
	protected $primaryKey = 'TRANSNO';
	
	public function getDetailsConnection($record = false){
		if(!$record){		
			return \App\Backdetail::ask()->where("TRANSNO","===", $this->TRANSNO)->get();
		}else{
			$TRANSNO = $record->getObjectByName("TRANSNO");
			return \App\Backdetail::ask()->where("TRANSNO","===", $TRANSNO)->get();
		}
		
	}
	
}
