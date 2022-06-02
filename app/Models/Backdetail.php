<?php namespace App\Models;
use \App\Traits\DbfTableTrait;
class Backdetail extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\DetailTrait;
    use DbfTableTrait;

	protected $table = "backdetails";

	  protected $seed = [
    'dbf_backdetail'
  ];
        protected $attributeTypes = [ 
        "_config"=>"backdetail",
      ];

      protected $indexes = ["KEY"];

    public $foreignKeys = [
        ["TRANSNO","TRANSNO","backheads"], //TRANSNO references TRANSNO on backheads
        ["PROD_NO","ISBN","inventories"], //PROD_NO references ISBN on inventories
    ];


	public function head()
    {
        return $this->belongsTo('App\Models\Backhead','TRANSNO','TRANSNO');
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
