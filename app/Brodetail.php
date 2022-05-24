<?php namespace App;

class Brodetail extends BaseModel {

	use \App\Ask\AskTrait\DetailTrait;
	
	protected $fillable = [ "INDEX", "ORDACTION", "ORDREASON", "JOBBERHOLD", "STATUS", "FASTPRINT", "TESTTRAN", "KEY", "TRANSNO", "PROD_NO", "REQUESTED", "SHIPPED", "AUTHOR", "TITLE", "SERIES", "ORDERNUM", "DATE", "ARTICLE", "LISTPRICE", "SALEPRICE", "DISC", "FORMAT", "PUBLISHER", "SOPLAN", "CAT", "SUBTITLE", "CATALOG", "AUTHORKEY", "TITLEKEY", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTDATE", "LASTTIME", "UNITCOST", "UPSELL", "PAGES", "OUNCES", "PUBDATE", "INVNATURE", "USERPASS", "ORDEREDBY", "EWHERE", "VISION", "REMOTEADDR", "dropship", "SCARTONNO", "TRANSNUM", "F856NUM", "KEYPO"];


	protected $table = "brodetails";
	
	public function head()
    {
        return $this->belongsTo('App\Brohead','TRANSNO','TRANSNO');
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
