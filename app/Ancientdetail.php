<?php namespace App;

class Ancientdetail extends BaseModel {
	
	use \App\Ask\AskTrait\DetailTrait;
	
	protected $fillable = ["INDEX", "KEY", "TRANSNO", "DATE", "REQUESTED", "SHIPPED", "PROD_NO", "AUTHOR", "ARTICLE", "TITLE", "INVNATURE", "LISTPRICE", "DISC", "TESTTRAN", "SALEPRICE", "PUBLISHER", "SUBTITLE", "FORMAT", "CAT", "SERIES", "SOPLAN", "CATALOG", "STATUS", "ORDERNUM", "UNITCOST", "TITLEKEY", "AUTHORKEY", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTTIME", "LASTDATE", "PAGES", "OUNCES", "PUBDATE", "REMOTEADDR", "USERPASS", "ORDEREDBY"];


	protected $table = "ancientdetails";
	
	public function head()
    {
        return $this->belongsTo('App\Ancienthead','TRANSNO','TRANSNO');
    }
	
	public function vendor()
    {
        return $this->belongsTo('App\Vendor','KEY','KEY');
    }
	
	public function book()
    {
        return $this->belongsTo('App\Inventory','PROD_NO','ISBN');
    }
}
