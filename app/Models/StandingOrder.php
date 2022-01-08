<?php namespace App\Models;

use \App\Traits\DbfTableTrait;

class StandingOrder extends BaseModel implements \App\Interfaces\ModelInterface {

    use DbfTableTrait;

	protected $table = "standing_orders";	
	protected $dbfPrimaryKey = 'INDEX';
	  protected $seed = [
        'dbf_standing_order'
      ];

      protected $attributeTypes = [ 
        "_config"=>"standing_order",
      ];

    public function scopeActive($query)
    {
        return $query->where('QUANTITY', '>', 0);
    }

    public function scopeInactive($query)
    {
        return $query->where('QUANTITY', '<=', 0);
    }

	public function vendor()
    {
    	return $this->belongsTo('App\Models\Vendor', 'KEY', 'KEY');
    }

    public function standingordersSchema($table){
		$table->foreign('KEY')->references('KEY')->on('vendors');
		//find out why there are keys in password that are not in vendor so i can uncoment this.
		return $table;
	}
	
}
