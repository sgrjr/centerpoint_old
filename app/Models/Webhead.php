<?php namespace App\Models;

use App\Traits\DbfTableTrait;

class Webhead extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\HeadTrait;
  use DbfTableTrait;

  public $fillable = ["KEY","ATTENTION", "DATE","BILL_1","BILL_2"."BILL_3","BILL_4","COMPANY","STREET","CITY","STATE","POSTCODE","VOICEPHONE","OSOURCE","ISCOMPLETE", "ROOM","DEPT","COUNTRY","FAXPHONE","EMAIL","SENDEMCONF","PO_NUMBER","CINOTE","CXNOTE","TRANSNO"];

  public $timestamps = false;
	protected $appends = [];
	protected $table = "webheads";
  protected $indexes = ["REMOTEADDR", "KEY"];
	protected $dbfPrimaryKey = 'REMOTEADDR';
    protected $seed = [
    'dbf_webhead'
  ];

  protected $attributeTypes = [ 
    "_config"=>"webhead",
  ];

    public function scopeIscomplete($query)
    {
        return $query->where('ISCOMPLETE', true);
    }

    public function scopeNotcomplete($query)
    {
        return $query->where('ISCOMPLETE', false);
    }


  // $record passed to getDetailsConnection must be an associative array
  // resulting from XBaseRecord->getRawData()


  public function items(){
    return $this->hasMany('\App\Models\Webdetail','REMOTEADDR','REMOTEADDR');
  }

  public function vendor(){
    return $this->belongsTo('\App\Models\Vendor','KEY','KEY');
  }

  public function getVendorConnection(array $record = []){

    if(empty($record)){
      $key = $this->getAttributes()["KEY"];
    }else{
      $key = $record["KEY"];
    }
    
    if(strpos($key,"04046") !== false){
      $vendor = new \App\Models\Vendor;
      $vendor->KEY = $key;
      $vendor->ORGNAME = "FAKE COMPANY";
      return $vendor;
    }else{
      return \App\Models\Vendor::ask()->where("KEY","===", $key)->first();
    }

    
  }

    public function updateShipping()
    {

      $records = $this->getDetailsConnection();
      $count = $records->paginator->count;
      $vendor = $this->getVendorConnection();
      if($vendor !== null){
         $SOLIST = $vendor->activeStandingOrders->records;   
      }else{
        $vendor = new \stdclass;
         $SOLIST = [];
      }
     
      $trade = 0;
      $cp = 0;

      foreach($records->records AS $att){

        if($att->INVNATURE !== "TRADE" && $att->referenceStandingOrderList($vendor->KEY, $SOLIST)->isInList){
          $cp += $att->REQUESTED;
        }else{
          $trade++;
        }

      }

      if($cp >= 5){
        $this->SHIPPING = 0.00;
      }
      
      $this->dbfSave();
      $this->save();
      
      return $this;
    }


	public static function newCart($user, $args, $returnCart = false){
    //\DB::enableQueryLog();
      $input = [];

      if(isset($args['input'])){
        $input = $args['input'];
      }
	    $uid=  time();//uniqid();
      
      $zip = substr($user->KEY,0,5);
      $REMOTEADDR =  $uid . $zip;
      $mytime = \Carbon\Carbon::now()->format("Ymd");
      
      $newCart = new \App\Models\Webhead;
      $newCart->REMOTEADDR = $REMOTEADDR;
      $newCart->KEY = $user->KEY;
      $newCart->DATE = $mytime;
      $newCart->BILL_1 = $user->vendor->ORGNAME;
      $newCart->BILL_2 =   "c/o " . $user->vendor->FIRST . " " . $user->vendor->LAST;
      $newCart->BILL_3 =   $user->vendor->STREET;
      $newCart->BILL_4 =   $user->vendor->CITY . ", " . $user->vendor->STATE . " " . $user->vendor->ZIP5;
      $newCart->COMPANY =  $user->vendor->ORGNAME;
      $newCart->STREET =  $user->vendor->STREET;
      $newCart->CITY =  $user->vendor->CITY;
      $newCart->STATE =  $user->vendor->STATE;
      $newCart->POSTCODE =  $user->vendor->ZIP5;
      $newCart->VOICEPHONE =  $user->vendor->VOICEPHONE;
      $newCart->OSOURCE = "INTERNET ORDER";
      $newCart->ISCOMPLETE = false;

      foreach($input AS $key=>$val){
        $newCart->$key = $val;
      }
  //must save to DBF first to get the new INDEX
       $newCart->INDEX = $newCart->dbfSave();
       $newCart->save();
    // file_put_contents('time', json_encode(\DB::getQueryLog()) . '----' .$newCart->INDEX . "\n", FILE_APPEND);

       if($returnCart){
          return $newCart;
       }
      return $user;
	}

  public function submitOrder($props = false){

    if($props){
      foreach($props AS $k => $v){
        $this->$k = $v;
      }
    }
    
    $this->ISCOMPLETE = "T";
    $this->dbfSave();
    $this->save();

    return $this;
  }

  public function deleteFromCart($isbn){
    foreach($this->items AS $item){
      if($item->PROD_NO === $isbn){
        $item->dbfDelete();
      }
    }

    $this->items->delete();

    return $this;
  }

public function webheadSchema($table){ $table->unique('REMOTEADDR'); return $table;	}

  public static function deleteCart($_, $args){

      $user = request()->user();      
      
        if(isset($args['id'])){
            $cart = static::where('id', $args['id'])->where('KEY', $user->KEY)->first();
        }else{
            $cart = static::where('REMOTEADDR', $args['REMOTEADDR'])->where('KEY', $user->KEY)->first();
        }

      if($cart !== null){
        $cart->items()->delete();
        $cart->delete();
      }


      if($user->vendor->cartsCount <= 0){
          $args = ["input"=>[]];
          $newcart = static::newCart($user, $args);
      }

      return $user;
  }

    public function updateMyCart($_, $args){
      
      $user = request()->user();
    
    if(isset($args['input']['id'])){
        $cart = static::where('id', $args['input']['id'])->where('KEY', $user->KEY)->first();
    }elseif(isset($args['input']['REMOTEADDR'])){
        $cart = static::where('REMOTEADDR', $args['input']['REMOTEADDR'])->where('KEY', $user->KEY)->first();
    }else{
      $cart = static::newCart(auth()->user(), $args["input"], true);
    }

      $args['input']['KEY'] = $user->KEY;
      $args['input']['DATE'] = \Carbon\Carbon::now()->format("Ymd");
      $cart->update($args['input']);
      return $cart;
}

    public function getMyCart($_, $args){

        $user = request()->user();

        if(isset($args['id'])){
            $cart = static::where('id', $args['id'])->where('KEY', $user->KEY)->first();
        }else{
            $cart = static::where('REMOTEADDR', $args['REMOTEADDR'])->where('KEY', $user->KEY)->first();
        }

        return $cart;
    }

protected static function boot()
    {
    /*
    EVENTS:
    creating and created: sent before and after records have been created.
    updating and updated: sent before and after records are updated.
    saving and saved: sent before and after records are saved (i.e created or updated).
    deleting and deleted: sent before and after records are deleted or soft-deleted.
    restoring and restored: sent before and after soft-deleted records are restored.
    retrieved: sent after records have been retrieved.
    */
        parent::boot();

        static::creating(function ($model) {
          // move curren tlogic in MUTATOR to here using "CREATE" directive in schema later
            //$model = static::prepareNewCartTitle($model);
        });

        static::saved(function ($model) {
         if(!isset($model->INDEX)){
              $model->INDEX = $model->dbfSave();
              $model->save();
          }else{
            $model->dbfSave();
          }
        });

        static::updating(function ($model) {
            //$model = static::prepareUpdateCartTitle($model);
        });

        static::deleted(function ($model) {
           $model->dbfDelete();
        });
    }

}