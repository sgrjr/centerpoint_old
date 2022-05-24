<?php namespace App;

class Alldetail extends BaseModel {

	use \App\Ask\AskTrait\DetailTrait;
	
	protected $fillable = [ "INDEX", "FUCKTRAN", "JOBBERHOLD", "ORDACTION", "ORDREASON", "TRANSNO", "TESTTRAN", "ORDERNUM", "KEY", "DATE", "PROD_NO", "REQUESTED", "SHIPPED", "ARTICLE", "AUTHOR", "TITLE", "LISTPRICE", "SALEPRICE", "CAT", "INVNATURE", "SERIES", "SOPLAN", "DISC", "PUBLISHER", "FORMAT", "SUBTITLE", "CATALOG", "STATUS", "UNITCOST", "TITLEKEY", "AUTHORKEY", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTTIME", "LASTDATE", "PAGES", "OUNCES", "PUBDATE", "REMOTEADDR", "USERPASS", "ORDEREDBY", "EWHERE", "SCARTONNO", "TRANSNUM", "F856NUM"];

	protected $table = "alldetails";

	public function head()
    {
        return $this->belongsTo('App\Allhead','TRANSNO','TRANSNO');
    }
	
	public function vendor()
    {
        return $this->belongsTo('App\Vendor','KEY','KEY');
    }
	
	public function book()
    {
        return $this->belongsTo('App\Inventory','prod_no','isbn');
    }
}