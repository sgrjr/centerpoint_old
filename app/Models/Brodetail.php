<?php namespace App\Models;
use \App\Models\Traits\DbfTableTrait;
class Brodetail extends BaseModel implements \App\Models\Interfaces\ModelInterface{

	use \App\Ask\AskTrait\DetailTrait;
	use DbfTableTrait;

	protected $table = "brodetails";

	  protected $seed = [
    'dbf_brodetail'
  ];

        protected $attributeTypes = [ 
        "_config"=>"brodetail",
      ];

    public $foreignKeys = [
        ["TRANSNO","TRANSNO","broheads"], //TRANSNO references TRANSNO on allheads
        ["PROD_NO","ISBN","inventories"], //PROD_NO references ISBN on inventories
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
