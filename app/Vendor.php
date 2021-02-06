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
  public function activeStandingOrders()
    {
        return $this->hasMany('App\StandingOrder','KEY','KEY')->active();
    }
  public function inactiveStandingOrders()
    {
        return $this->hasMany('App\StandingOrder','KEY','KEY')->inactive();
    }
	
	public function orders()
    {
        return $this->hasMany('App\Order','KEY','KEY');
    }

	public function broOrders()
    {
        return $this->hasMany('App\Brohead','KEY','KEY');
    }

      public function backOrders()
    {
        return $this->hasMany('App\Backhead','KEY','KEY');
    }

    public function ancientOrders()
    {
        return $this->hasMany('App\Ancienthead','KEY','KEY');
    }

    public function allOrders()
    {
        return $this->hasMany('App\Allhead','KEY','KEY');
    }

	public function orderItems()
    {
       return $this->hasMany('App\OrderItem','KEY','KEY')->get();
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

	 public function users(){
         return $this->hasMany('App\User','KEY','KEY');
    }

    public function processing(){
        return $this->hasMany('App\Webhead','KEY','KEY')->iscomplete();
    }

    public function carts()
    {
       return $this->hasMany('App\Webhead','KEY','KEY')->notcomplete();
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
