<?php namespace App;
use \App\Core\DbfTableTrait;
class Brodetail extends BaseModel implements \App\Interfaces\ModelInterface{

	use \App\Ask\AskTrait\DetailTrait;
	use DbfTableTrait;

	protected $table = "brodetails";

	  protected $seed = [
    'dbf_brodetail'
  ];

        protected $attributeTypes = [ 
        "_config"=>"brodetail",
      ];

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
}
