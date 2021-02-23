<?php namespace App;
use \App\Core\DbfTableTrait;
use Cache;

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

      protected $appends = ['summary','isbns'];

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

	public function broOrders()
    {
        return $this->hasMany('App\Brohead','KEY','KEY');
    }
  public function brodetailsOrders()
    {
        return $this->hasMany('App\Brodetail','KEY','KEY');
    }

      public function backOrders()
    {
        return $this->hasMany('App\Backhead','KEY','KEY');
    }

      public function backdetailsOrders()
    {
        return $this->hasMany('App\Backdetail','KEY','KEY');
    }

    public function ancientOrders()
    {
        return $this->hasMany('App\Ancienthead','KEY','KEY');
    }

    public function ancientdetailsOrders()
    {
        return $this->hasMany('App\Ancientdetail','KEY','KEY');
    }


    public function allOrders()
    {
        return $this->hasMany('App\Allhead','KEY','KEY');
    }

    public function alldetailsOrders()
    {
        return $this->hasMany('App\Alldetail','KEY','KEY');
    }

    public function webdetailsOrders()
    {
        return $this->hasMany('App\Webdetail','KEY','KEY');
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


    public function getInvoice($_, $args){

        $user = request()->user();
        $cart = \App\Allhead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();

        if($cart === null){
          $cart = \App\Ancienthead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();

          if($cart === null){
            $cart = \App\Backhead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();

            if($cart === null){
              $cart = \App\Brohead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();

              if($cart === null){
                $cart = \App\Webhead::where('TRANSNO', $args['TRANSNO'])->where('KEY', $user->KEY)->first();
                  if($cart === null){
                    $cart = \App\Webhead::where('REMOTEADDR', $args['TRANSNO'])->where('KEY', $user->KEY)->first();
                  }
              }
            }
          }
        }

        return $cart;
    }



}
