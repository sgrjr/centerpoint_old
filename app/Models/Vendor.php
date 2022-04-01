<?php namespace App\Models;
use \App\Traits\DbfTableTrait;
use Cache;

use \App\Models\Passfile;
use App\Models\Allhead;
use App\Models\Ancienthead;
use App\Models\Backhead;
use App\Models\Brohead;
use App\Models\Webhead;

class Vendor extends BaseModel implements \App\Interfaces\ModelInterface {

    use DbfTableTrait;

    private $VENDOR_CACHE_MINUTES = 15;
	protected $table = "vendors";
    protected $indexes = ["KEY"];

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

      protected $appends = ['summary','isbns'];

	public function standingOrders()
    {
        return $this->hasMany('App\Models\StandingOrder','KEY','KEY');
    }
  public function activeStandingOrders()
    {
        return $this->hasMany('App\Models\StandingOrder','KEY','KEY')->active();
    }
  public function inactiveStandingOrders()
    {
        return $this->hasMany('App\Models\StandingOrder','KEY','KEY')->inactive();
    }

	public function broOrders()
    {
        return $this->hasMany('App\Models\Brohead','KEY','KEY');
    }
  public function brodetailsOrders()
    {
        return $this->hasMany('App\Models\Brodetail','KEY','KEY');
    }

      public function backOrders()
    {
        return $this->hasMany('App\Models\Backhead','KEY','KEY');
    }

      public function backdetailsOrders()
    {
        return $this->hasMany('App\Models\Backdetail','KEY','KEY');
    }

    public function ancientOrders()
    {
        return $this->hasMany('App\Models\Ancienthead','KEY','KEY');
    }

    public function ancientdetailsOrders()
    {
        return $this->hasMany('App\Models\Ancientdetail','KEY','KEY');
    }


    public function allOrders()
    {
        return $this->hasMany('App\Models\Allhead','KEY','KEY');
    }

    public function alldetailsOrders()
    {
        return $this->hasMany('App\Models\Alldetail','KEY','KEY');
    }

    public function webdetailsOrders()
    {
        return $this->hasMany('App\Models\Webdetail','KEY','KEY');
    }

    public function getIsbnsAttribute()
    {

          $key = $this->KEY . "_isbns";
          //Cache::forget($key);

          return Cache::remember($key, 1800, function () {

            $all = $this->alldetailsOrders()->pluck('PROD_NO')->toArray();
            $ancient = $this->ancientdetailsOrders()->pluck('PROD_NO')->toArray();
            $back = $this->backdetailsOrders()->pluck('PROD_NO')->toArray();
            $bro = $this->brodetailsOrders()->pluck('PROD_NO')->toArray();
            $web = $this->webdetailsOrders()->pluck('PROD_NO')->toArray();
            $list = collect(array_merge($all, $ancient,$back,$bro,$web));
            $newList = [];

            foreach($list AS $title){
              $newList[$title] = $title;
            }
            return $newList;
          });
    }

    public function calcWholeSaleDisount(){
	  //wholesale discount

	  $passfile = Passfile::ask()->where('KEY',"===",$this->present()->KEY)->first();

	  if($passfile !== null){
	    return $passfile->discount;
	  }else{
	    return false;
	  }

	}

	 public function users(){
         return $this->hasMany('App\Models\User','KEY','KEY');
    }

    public function processing(){
        return $this->hasMany('App\Models\Webhead','KEY','KEY')->iscomplete();
    }

    public function carts()
    {
       return $this->hasMany('App\Models\Webhead','KEY','KEY')->notcomplete()->notDeleted();
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


    public function getInvoice($_, $args){

        $user = request()->user();
        $cart = Allhead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();

        if($cart === null){
          $cart = Ancienthead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();

          if($cart === null){
            $cart = Backhead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();

            if($cart === null){
              $cart = Brohead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();

              if($cart === null){
                $cart = Webhead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();
                  if($cart === null){
                    $cart = Webhead::where('REMOTEADDR', $args['TRANSNO'])->where('KEY', $user->KEY)->first();
                  }
              }
            }
          }
        }

        return $cart;
    }

}
