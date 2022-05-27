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

    public function webOrders()
    {
        return $this->hasMany('App\Models\Allhead','KEY','KEY');
    }

    public function webdetailsOrders()
    {
        return $this->hasMany('App\Models\Webdetail','KEY','KEY');
    }

    private function addUnique($parent_array, $array_to_add){

        $new_items = [];
        foreach($array_to_add AS $atd){

            if(count($parent_array) < 1){
                $new_items[] = $atd;
                break;
            }

            foreach($parent_array AS $pa){
                foreach($atd AS $key => $val){
                    if($val !== $pa[$key]){
                        $new_items[] = $atd;
                        break 3;
                    }
                }

            }
        }

        return array_merge($parent_array, $new_items);
    }

    public function getEveryAddress($count = 10){
            
            $addresses = [];
            //webhead
            $web = $this->webOrders()->select('BILL_1','BILL_2','BILL_3','BILL_4')->take($count)->get()->toArray();

            $addresses = $this->addUnique($addresses, $web);

            if(count($addresses) < $count){
                $back = $this->backOrders()->select('BILL_1','BILL_2','BILL_3','BILL_4')->take($count-count($addresses))->get()->toArray();
                 $addresses = $this->addUnique($addresses, $back);

                if(count($addresses) < $count){
                    $bro = $this->broOrders()->select('BILL_1','BILL_2','BILL_3','BILL_4')->take($count-count($addresses))->get()->toArray();
                     $addresses = $this->addUnique($addresses, $bro);

                    if(count($addresses) < $count){
                        $all = $this->allOrders()->select('BILL_1','BILL_2','BILL_3','BILL_4')->take($count-count($addresses))->get()->toArray();
                         $addresses = $this->addUnique($addresses, $all);

                         if(count($addresses) < $count){
                            $ancient = $this->ancientOrders()->select('BILL_1','BILL_2','BILL_3','BILL_4')->take($count-count($addresses))->get()->toArray();
                             $addresses = $this->addUnique($addresses, $ancient);
                         }
                    }
                }
            }
            
            return $addresses;
    }

    public function getIsbnsAttribute()
    {

          $key = $this->KEY . "_isbns";
          //Cache::forget($key);

          return Cache::remember($key, 900, function () {

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

        if(isset($args['TRANSNO'])){
            $key = 'TRANSNO';
        }else{
            $key = 'REMOTEADDR';
        }

        $user = request()->user();
        $cart = Allhead::where($key, $args[$key])->where('KEY', $user->KEY)->first();

        if($cart === null){
          $cart = Ancienthead::where($key, $args[$key])->where('KEY', $user->KEY)->first();

          if($cart === null){
            $cart = Backhead::where($key, $args[$key])->where('KEY', $user->KEY)->first();

            if($cart === null){
              $cart = Brohead::where($key, $args[$key])->where('KEY', $user->KEY)->first();

              if($cart === null){
                $cart = Webhead::where($key, $args[$key])->where('KEY', $user->KEY)->first();
                  if($cart === null){
                    if($key === "TRANSNO"){
                        $cart = Webhead::where('REMOTEADDR', $args[$key])->where('KEY', $user->KEY)->first();
                    }else{
                        $cart = Webhead::where('TRANSNO', $args[$key])->where('KEY', $user->KEY)->first();
                    }
                    
                  }
              }
            }
          }
        }

        return $cart;
    }

    public function getAddressesAttribute(){
        return Cache::get($this->KEY.'_every_address', function () {
            return $this->getEveryAddress(6);
        });
    }

}
