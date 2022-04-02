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

	public function vendor()
    {
    	return $this->belongsTo('App\Models\Vendor', 'KEY', 'KEY');
    }

    /*
    2014 - AM INDICATES COMP PLANS
2013 - AM INDICATES COMP PLANS
2016 AM INDICATES COMP PLANS
PLATINUM FICTION SERIES
PLATINUM MYSTERY SERIES
PLATINUM NONFICTION SERIES
PLATINUM ROMANCE SERIES
PLATINUM SPOTLIGHT SERIES
X - PREMIER MYSTERY SERIES
X - PREMIER FICTION SERIES
X - WESTERN SERIES LEVEL I (24)
X - STERLING MYSTERY SERIES
X - PLATINUM FICTION SERIES
X - CHOICE OPTION (48)
X - PLATINUM ROMANCE SERIES
X - PLATINUM SPOTLIGHT SERIES
X - TRADE PLAN LEVEL   I (24)
X - PLATINUM MYSTERY SERIES
TRADE SELECT
BESTSELLER SERIES (12)
PREMIER FICTION SERIES
PREMIER ROMANCE SERIES
X - PLATINUM NONFICTION SERIES
CHOICE OPTION (24)
X - CHOICE OPTION (24)
X - CHRISTIAN SERIES LEVEL I (24)
X - TRADE PLAN LEVEL III (72)
X - WESTERN SERIES LEVEL II (24)
X - CHOICE OPTION (100)
STERLING MYSTERY SERIES
CUSTOM PLATINUM SERIES MIX
PREMIER MYSTERY SERIES
X - AGATHA CHRISTIE SERIES
TRADE PLAN LEVEL   I (24)
CHOICE OPTION (100)
CHOICE OPTION (48)
X - CHRISTIAN SERIES LEVEL II (24)
CHRISTIAN SERIES LEVEL I (24)
X - PREMIER ROMANCE SERIES
CUSTOM CHRISTIAN MIX
TRADE PLAN LEVEL III (72)
X - CHRISTIAN SERIES LEVEL III (24)
TRADE PLAN LEVEL  II (48)
X - TRADE PLAN LEVEL  II (48)
CHRISTIAN SERIES LEVEL II (24)
CHRISTIAN SERIES LEVEL III (24)
WESTERN SERIES LEVEL I (24)
WESTERN SERIES LEVEL II (24)
WESTERN SERIES LEVEL III (24)
CUSTOM MULTI SERIES MIX
CUSTOM PREMIER SERIES MIX
BESTSELLER SERIES (24)
X - CUSTOM PLATINUM SERIES MIX
BESTSELLER SERIES (36)
X - PREMIER SERIES PLUS (24)
X - CUSTOM MULTI SERIES MIX
X - BESTSELLER SERIES (12)
X - BESTSELLER SERIES (36)

X - WESTERN SERIES LEVEL III (24)
X - BESTSELLER SERIES (24)
X - CUSTOM CHRISTIAN MIX
X - PLATNUM SPOTLIGHT SERIES
X - PLATNUM MYSTERY SERIES
2017 AM INDICATES COMP PLANS
2018 AM INDICATES COMP PLANS
X - CUSTOM PREMIER SERIES MIX
2020 AM INDICATES COMP PLANS
2021 AM INDICATES COMP PLANS
2022 AM INDICATES COMP PLANS
*/
	/**
     * Get the Standing Order's DISC attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function discount(): Attribute
    {
        return new Attribute(
            get: fn () => 50.00
        );
    }
}
