<?php namespace App;
use \App\Core\DbfTableTrait;
class Ancientdetail extends BaseModel implements \App\Interfaces\ModelInterface {
	
	use \App\Ask\AskTrait\DetailTrait;
    use DbfTableTrait;
    	
	protected $fillable = ["INDEX", "KEY", "TRANSNO", "DATE", "REQUESTED", "SHIPPED", "PROD_NO", "AUTHOR", "ARTICLE", "TITLE", "INVNATURE", "LISTPRICE", "DISC", "TESTTRAN", "SALEPRICE", "PUBLISHER", "SUBTITLE", "FORMAT", "CAT", "SERIES", "SOPLAN", "CATALOG", "STATUS", "ORDERNUM", "UNITCOST", "TITLEKEY", "AUTHORKEY", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTTIME", "LASTDATE", "PAGES", "OUNCES", "PUBDATE", "REMOTEADDR", "USERPASS", "ORDEREDBY"];


	protected $table = "ancientdetails";

    protected $seed = [
        'dbf_ancientdetail'
    ];
    protected $dbfPrimaryKey = "TRANSNO";

      protected $attributeTypes = [ 
        "_config"=>"ancientdetail",
      ];

	public function head()
    {
        return $this->belongsTo('App\AncientHead','TRANSNO','TRANSNO');
    }
	
	public function vendor()
    {
        return $this->belongsTo('App\Vendor','KEY','KEY');
    }
	
	public function book()
    {
        return $this->belongsTo('App\Inventory','PROD_NO','ISBN');
    }

    public function ancientdetailSchema($table){
       return $table->foreign('TRANSNO')->references('TRANSNO')->on('ancientheads');
    }
}
