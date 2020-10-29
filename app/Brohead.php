<?php namespace App;
use \App\Core\DbfTableTrait;
class BroHead extends BaseModel implements \App\Interfaces\ModelInterface {
	
	use \App\Ask\AskTrait\HeadTrait;
    use DbfTableTrait;
    
	protected $fillable = ["INDEX","KICKBACK","INVQUERY","INVLMNT","PROMONAME","MASTERPASS","MASTERDATE","NEWREMOTE","REMOTEADDR","BITEMS","BPRODUCT","KEY","DATE","TESTTRAN","BILL_1","PSHIP","PIPACK","PEPACK","PINVOICE","NEWPRODUCT","PRODUCT","USERPASS","ORDEREDBY","ITEMS","NEWITEMS","TITEMS","TPRODUCT","SHIPPING","SALESTAX","OTHERDESC","OTHER","FREESHIP","SHIPMETHOD","BILLUPDATE","SHIPUPDATE","MAILUPDATE","ORDUPDATE","BILL_2","BILL_3","BILL_4","BILL_5","COMPANY","ATTENTION","STREET","ROOM","DEPT","CITY","STATE","POSTCODE","COUNTRY","VOICEPHONE","FAXPHONE","EMAIL","SENDEMCONF","PO_NUMBER","COMPUTER","TIMESTAMP","DATESTAMP","LASTTOUCH","LASTDATE","LASTTIME","UPS_KEY","UPSDATE","BILLWEIGHT","PACKAGES","COMMCODE","TERMS","OSOURCE","OSOURCE2","OSOURCE3","OSOURCE4","PAID","PAIDAMOUNT","PAIDDATE","PAYTYPE","SPECIALD","CANBILL","TAXEXEMPT","ISCOMPLETE","SORTORDER","SHIPPER","DATEIN","DATEOUT","TIMEIN","TIMEOUT","HOTBOX","CINOTE","CXNOTE","LASTCHECK","F810SENT","F855NUM","F855SENT","F856SENT","LASTVIEW","CPHOLD","LOGOFFPOST","LOGOFFSAVE","TRANSNO"];


	protected $appends = [];
	protected $table = "broheads";	
<<<<<<< HEAD
	protected $dbfPrimaryKey = 'TRANSNO';
	protected $seed = [
    	'dbf_brohead'
  	];

      protected $attributeTypes = [ 
        "_config"=>"brohead",
      ];
=======
	protected $primaryKey = 'TRANSNO';
	
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

	public function getDetailsConnection($record = false){
		if(!$record){		
			return \App\BroDetail::ask()->where("TRANSNO","===", $this->TRANSNO)->get();
		}else{
			$TRANSNO = $record->getObjectByName("TRANSNO");
			return \App\BroDetail::ask()->where("TRANSNO","===", $TRANSNO)->get();
		}
		
	}

	public function broheadSchema($table){$table->unique('TRANSNO'); return $table;}
}
