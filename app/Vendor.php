<?php namespace App;
use \App\Core\DbfTableTrait;
class Vendor extends BaseModel implements \App\Interfaces\ModelInterface {

    use DbfTableTrait;

    private $VENDOR_CACHE_MINUTES = 15;
	protected $table = "vendors";

	protected $dbfPrimaryKey = 'KEY';
    protected $casts = [
        'KEY' => 'string',
    ];
      protected $seed = [
    'dbf_vendor'
  ];

      protected $attributeTypes = [ 
        "_config"=>"vendor",
      ];

      protected $appends = ['summary'];

	public function standingOrders()
    {
        return $this->hasMany('App\StandingOrder','KEY','KEY');
    }
	
	public function orders()
    {
        return $this->hasMany('App\Order','KEY','KEY');
    }

	public function orderHead()
    {
        return $this->hasMany('App\BroHead','KEY','KEY');
    }
	public function getOrderItemsAttribute()
    {
        
        $od = new \App\OrderItem();

        if(!$od->tableExists || $od->count() <= 0){
                $od->seedTable();
		}
            
        //return \Cache::remember('vendor_titles_' . $this->KEY, $this->VENDOR_CACHE_MINUTES, function () {
            return $this->hasMany('App\OrderItem','KEY','KEY')->get();
        //});
    }

    public function calcWholeSaleDisount(){
	  //wholesale discount

	  $passfile = \App\Passfile::ask()->where('KEY',"===",$this->present()->KEY)->first();

	  if($passfile !== null){
	    return $passfile->discount;
	  }else{
	    return false;
	  }

	}

	 public function getStandingOrdersConnection($test = false){
    	$result = \App\StandingOrder::ask()->setPerPage(9999);

        if($test !== false){
            foreach($test AS $t){
                $result->where($t[0],$t[1],$t[2]); 
            }
            
        }
        return $result->where("KEY","==", $this->present()->KEY)->get();
    }

    public function getActiveStandingOrdersAttribute(){
        $test = [
            ["QUANTITY",">","0"]
        ];
       return \Cache::remember('vendor_active_standing_orders_' . $this->KEY, $this->VENDOR_CACHE_MINUTES, function () use ($test){
            return $this->getStandingOrdersConnection($test);
        });

    }

    public function getInactiveStandingOrdersAttribute(){
        $test = [
            ["QUANTITY","<","1"]
        ];
       return \Cache::remember('vendor_inactive_standing_orders_' . $this->KEY, $this->VENDOR_CACHE_MINUTES, function () use ($test){
            return $this->getStandingOrdersConnection($test);
        });
    }

	 public function getUsersAttribute(){
        return \App\Password::ask()->where("KEY","===", $this->KEY)->get();
    }

    public function processing(){
        return $this->hasMany('App\Webhead','KEY','KEY')->where('ISCOMPLETE', "!==",true);
    }

    public function carts()
    {
       return $this->hasMany('App\Webhead','KEY','KEY')->where('ISCOMPLETE',true);
    }

    public function getCartsCountAttribute(){

         return count($this->carts);
      }

      public function getProcessingCountAttribute(){

         return count($this->processing);
      }

         public function getSummaryAttribute(){

            return [
                "carts_count" => $this->cartsCount,
                "processing_count" => $this->processingCount 

            ];

          }

      	public function vendorSchema($table){
		    //$table->index('KEY'); //find out why there are duplicate keys so i can change this to unique('KEY'). right now is getting error on insert due to duplicates.
		    return $table;
	    }
}
