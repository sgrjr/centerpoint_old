<?php namespace App\Models;

use \App\Traits\DbfTableTrait;

class StandingOrder extends BaseModel implements \App\Interfaces\ModelInterface {

    use DbfTableTrait;

	protected $table = "standing_orders";	
	protected $dbfPrimaryKey = 'INDEX';
    protected $indexes = ["KEY"];
      protected $seed = [
        'dbf_standing_order'
      ];

      protected $attributeTypes = [ 
        "_config"=>"standing_order",
      ];

    public $foreignKeys = [
        ["KEY","KEY","vendors"], //KEY references KEY on vendors
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
	
}
