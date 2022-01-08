<?php namespace App\Models;
use \App\Traits\DbfTableTrait;
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
        return $this->belongsTo('App\Models\Brohead','TRANSNO','TRANSNO');
    }
	
	public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor','KEY','KEY');
    }
	
	public function book()
    {
        return $this->belongsTo('App\Models\Inventory','PROD_NO','ISBN');
    }
}
