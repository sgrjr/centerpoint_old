<?php namespace App\Models;

use \App\Traits\DbfTableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public $appends = ["discount"];

    public function scopeActive($query)
    {
        return $query->where('QUANTITY', '>', 0);
    }

    public function scopeInactive($query)
    {
        return $query->where('QUANTITY', '<=', 0);
    }

    public function getIsActiveAttribute(){
        return $this->QUANTITY > 0;
    }

	public function vendor()
    {
    	return $this->belongsTo('App\Models\Vendor', 'KEY', 'KEY');
    }
	/**
     * Get the Standing Order's DISC attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function discount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->calcDiscount(),
        );
    }

    protected function calcDiscount(){
        switch($this->SOSERIES){

            case 'CHOICE OPTION (24)':
                return .30;
                break;
            case 'CHOICE OPTION (48)':
                return .35;
                break;
            case 'CHOICE OPTION (100)':
                return .40;
                break;
            default:
                return .25;
        }
        
    }
}
