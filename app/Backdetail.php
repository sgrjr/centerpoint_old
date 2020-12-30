<?php namespace App;
use \App\Core\DbfTableTrait;
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

	public function head()
    {
        return $this->belongsTo('App\BackHead','TRANSNO','TRANSNO');
    }
	
	public function vendor()
    {
        return $this->belongsTo('App\Vendor','KEY','KEY');
    }
	
	public function book()
    {
        return $this->belongsTo('App\Inventory','PROD_NO','ISBN');
    }

    public function backdetailSchema($table){
        $table->foreign('transno')->references('transno')->on('backhead'); 
        return $table;
    }
}
