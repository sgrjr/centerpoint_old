<?php namespace App;

use \App\Core\DbfTableTrait;

class StandingOrder extends BaseModel implements \App\Interfaces\ModelInterface {

    use DbfTableTrait;
    
	protected $fillable = ["INDEX","BDUE","BPUR","THEREC","HERE","KEY","QUANTITY","SOSERIES","BILL_1","BILL_2","BILL_3","BILL_4","BILL_5","PO_NUMBER","PREPAID","SDATE","EDATE","COMPANY","STREET","DEPT","CITY","STATE","POSTCODE","COUNTRY","FREESHIP","SHIPMETHOD","DISC","HANDLING","OTHER","OTHERDESC","IOFFER","CXNOTE","CINOTE","TINOTE","DATESTAMP","TIMESTAMP","COMPUTER","LASTDATE","LASTTIME","LASTTOUCH","COMMCODE","EMAIL","CANCELDATE","RESTATE","HOTBOX","LASTORDD","NCOMMCODE","OLDCODE","INVPREP","EXP_MONTH","EXP_YEAR","BADRECORD","PASSBY","PERTIME","PERBOOKS","BOOKS","DAYS","SKIPOVER","HIDE","XRANDOM","XHARDONLY","XSOFTONLY","CMONTH","CCONTINUE","TRADTA","VOICEPHONE","CARDKITS","NOCHFIC","NOCHROM","NOCHMYS"
];

<<<<<<< HEAD
	protected $table = "standing_orders";	
	protected $dbfPrimaryKey = 'INDEX';
	  protected $seed = [
        'dbf_standing_order'
      ];

      protected $attributeTypes = [ 
        "_config"=>"standing_order",
      ];

=======
	protected $table = "standingorders";	
	protected $primaryKey = 'KEY';
	
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
	public function vendor()
    {
    	return $this->belongsTo('App\Vendor', 'KEY', 'KEY');
    }

    public function standingordersSchema($table){
		$table->foreign('KEY')->references('KEY')->on('vendors');
		//find out why there are keys in password that are not in vendor so i can uncoment this.
		return $table;
	}
	
}
