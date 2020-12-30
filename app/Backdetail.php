<?php namespace App;
use \App\Core\DbfTableTrait;
class Backdetail extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\DetailTrait;
    use DbfTableTrait;
    	
	protected $fillable = ["INDEX", "FASTPRINT", "FSTATUS", "FDATE", "TRANSNO", "ORDERNUM", "KEY", "REQUESTED", "PROD_NO", "PUBDATE", "AUTHOR", "TITLE", "COMSHIP", "MOMSHIP", "RENSHIP", "SOMSHIP", "TONHAND", "SHIPNOW", "BACKNOW", "KILLNOW", "HOLDNOW", "DATESTAMP", "INVNATURE", "TESTTRAN", "STATUS", "DATE", "TIMESTAMP", "SERIES", "SENDSTATUS", "JOBBERHOLD", "ORDACTION", "ORDREASON", "ONODATE", "ORDERDATE", "ORDERED", "SHIPPED", "ARTICLE", "SOPLAN", "ELSEWHERE", "SUBTITLE", "LISTPRICE", "SALEPRICE", "DISC", "FORMAT", "PUBLISHER", "CAT", "CATALOG", "COMPUTER", "LASTTOUCH", "LASTDATE", "LASTTIME", "AUTHORKEY", "TITLEKEY", "UNITCOST", "PAGES", "OUNCES", "REMOTEADDR", "USERPASS", "ORDEREDBY", "EWHERE"];

	protected $table = "backdetails";

	  protected $seed = [
    'dbf_backdetail'
  ];
        protected $attributeTypes = [ 
        "_config"=>"backdetail",
      ];

	public function head()
    {
        return $this->belongsTo('App\BackHead','TRANSNO','TRANSNO');
    }
	
	public function vendor()
    {
        return $this->belongsTo('App\Vendor','KEY','KEY');
    }
	
	public function book()
    {
        return $this->belongsTo('App\Inventory','PROD_NO','ISBN');
    }

    public function backdetailSchema($table){
        $table->foreign('transno')->references('transno')->on('backhead'); 
        return $table;
    }
}
