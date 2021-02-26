<?php namespace App;
use \App\Core\DbfTableTrait;
class Ancientdetail extends BaseModel implements \App\Interfaces\ModelInterface {
	
	use \App\Ask\AskTrait\DetailTrait;
    use DbfTableTrait;

	protected $table = "ancientdetails";

    protected $seed = [
        'dbf_ancientdetail'
    ];
    protected $dbfPrimaryKey = "TRANSNO";

      protected $attributeTypes = [ 
        "_config"=>"ancientdetail",
      ];

      protected $ignoreColumns = [ 
        "PAGES","OUNCES","TESTTRAN","USERPASS","ORDERNUM","CAT","SUBTITLE","ARTICLE","LASTTOUCH","LASTTIME","LASTDATE","TITLEKEY","AUTHORKEY","UNITCOST","ORDEREDBY","PUBDATE","FORMAT","COMPUTER","INVNATURE","FORMAT","PUBLISHER","CATALOG","STATUS","SOPLAN","TIMESTAMP","DATESTAMP","SERIES","REMOTEADDR"
      ];

      protected $fillable = ["KEY","TRANSNO","DATE","REQUESTED","SHIPPED","PROD_NO","AUTHOR","TITLE","LISTPRICE","DISC","SALEPRICE","SERIES","INDEX"];

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
}
