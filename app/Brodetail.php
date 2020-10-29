<?php namespace App;
use \App\Core\DbfTableTrait;
class BroDetail extends BaseModel implements \App\Interfaces\ModelInterface{

	use \App\Ask\AskTrait\DetailTrait;
	use DbfTableTrait;

	protected $fillable = [ "INDEX", "ORDACTION", "ORDREASON", "JOBBERHOLD", "STATUS", "FASTPRINT", "TESTTRAN", "KEY", "TRANSNO", "PROD_NO", "REQUESTED", "SHIPPED", "AUTHOR", "TITLE", "SERIES", "ORDERNUM", "DATE", "ARTICLE", "LISTPRICE", "SALEPRICE", "DISC", "FORMAT", "PUBLISHER", "SOPLAN", "CAT", "SUBTITLE", "CATALOG", "AUTHORKEY", "TITLEKEY", "COMPUTER", "TIMESTAMP", "DATESTAMP", "LASTTOUCH", "LASTDATE", "LASTTIME", "UNITCOST", "UPSELL", "PAGES", "OUNCES", "PUBDATE", "INVNATURE", "USERPASS", "ORDEREDBY", "EWHERE", "VISION", "REMOTEADDR", "DROPSHIP", "SCARTONNO", "TRANSNUM", "F856NUM", "KEYPO"];


	protected $table = "brodetails";
<<<<<<< HEAD
	  protected $seed = [
    'dbf_brodetail'
  ];

        protected $attributeTypes = [ 
        "_config"=>"brodetail",
      ];
=======
	
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
	public function head()
    {
        return $this->belongsTo('App\BroHead','TRANSNO','TRANSNO');
    }
	
	public function vendor()
    {
        return $this->belongsTo('App\Vendor','KEY','KEY');
    }
	
	public function book()
    {
        return $this->belongsTo('App\Inventory','PROD_NO','ISBN');
    }

    public function brodetailSchema($table)
    {
        $table->foreign('TRANSNO')->references('TRANSNO')->on('broheads');
        return $table;
    }
}
