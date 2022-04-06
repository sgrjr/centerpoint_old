<?php namespace App\Models;

use App\Traits\DbfTableTrait;
use App\Traits\DbfValidationTrait;

class Webhead extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\HeadTrait;
  use DbfTableTrait;
  use DbfValidationTrait;

  public $fillable = ["INDEX","KEY","ATTENTION", "DATE","BILL_1","BILL_2","BILL_3","BILL_4","COMPANY","STREET","CITY","STATE","POSTCODE","VOICEPHONE","OSOURCE","ISCOMPLETE", "ROOM","DEPT","COUNTRY","FAXPHONE","EMAIL","SENDEMCONF","PO_NUMBER","CINOTE","CXNOTE","TRANSNO","DATESTAMP","TIMESTAMP","LASTDATE","LASTTIME","LASTTOUCH","REMOTEADDR","DELETED"];

  public $timestamps = false;
	protected $appends = [];
	protected $table = "webheads";
  protected $indexes = ["REMOTEADDR", "KEY"];
	protected $dbfPrimaryKey = 'REMOTEADDR';
  protected $seed = [
    'dbf_webhead'
  ];

  protected $requiredAttributes = [
    "KEY",
    "DATE",
    "DATESTAMP",
    "TIMESTAMP",
    "LASTDATE",
    "LASTTIME",
    "LASTTOUCH",
    "REMOTEADDR"
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

    public function scopeNotDeleted($query)
    {
        return $query->where('DELETED', false);
    }


  // $record passed to getDetailsConnection must be an associative array
  // resulting from XBaseRecord->getRawData()


  public function items(){
    return $this->hasMany('\App\Models\Webdetail','REMOTEADDR','REMOTEADDR')->notDeleted();
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

  public function generateRemoteAddr($user){
      $uid=  time();//uniqid();
      $zip = substr($user->KEY,0,5);
      return $uid . $zip;
  }

  public function fillAttributes($user = false){

    /* MAKE SURE ARGS HAVE USER & VENDOR INFO */
    /*
    KEY = string
    ORDEREDBY = $email
    LASTTOUCH = $email
    BILL_1 = $user->vendor->ORGNAME;
    BILL_2 =   "c/o " . $user->vendor->FIRST . " " . $user->vendor->LAST;
    BILL_3 =   $user->vendor->STREET;
    BILL_4 =   $user->vendor->CITY . ", " . $user->vendor->STATE . " " . $user->vendor->ZIP5;
    COMPANY =  $user->vendor->ORGNAME;
    STREET =  $user->vendor->STREET;
    CITY =  $user->vendor->CITY;
    STATE =  $user->vendor->STATE;
    POSTCODE =  $user->vendor->ZIP5;
    VOICEPHONE =  $user->vendor->VOICEPHONE;
    */

    if(!$user){$user = request()->user;}

    $now = \Carbon\Carbon::now();

    $this
      ->setIfNotSet('KEY',$user->KEY)
      ->setIfNotSet('REMOTEADDR',$this->generateRemoteAddr($user))
      ->setIfNotSet('ISCOMPLETE', false)
      ->setIfNotSet('OSOURCE','INTERNET ORDER')
      ->setIfNotSet('DATE', $now->format("Ymd"))
      ->setIfNotSet('DATESTAMP', $now->format("Ymd"))
      ->setIfNotSet('LASTDATE', $now->format("Ymd"))
      ->setIfNotSet('TIMESTAMP', $now->format("h:i:s"))
      ->setIfNotSet('LASTTIME', $now->format("h:i:s"))
      ->setIfNotSet('ORDEREDBY',$user->EMAIL)
      ->setIfNotSet('LASTTOUCH',$user->KEY)
      ->setIfNotSet('BILL_1',$user->vendor->ORGNAME)
      ->setIfNotSet('BILL_2',"c/o " . $user->vendor->FIRST . " " . $user->vendor->LAST)
      ->setIfNotSet('BILL_3',$user->vendor->STREET)
      ->setIfNotSet('BILL_4',$user->vendor->CITY . ", " . $user->vendor->STATE . " " . $user->vendor->ZIP5Y)
      ->setIfNotSet('COMPANY',$user->vendor->ORGNAME)
      ->setIfNotSet('STREET',$user->vendor->STREET)
      ->setIfNotSet('CITY',$user->vendor->CITY)
      ->setIfNotSet('STATE',$user->vendor->STATE)
      ->setIfNotSet('POSTCODE',$user->vendor->ZIP5)
      ->setIfNotSet('VOICEPHONE',$user->vendor->VOICEPHONE);

      return $this;
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
      
      return $this;
    }

  public function submitOrder($props = false){

    if($props){
      foreach($props AS $k => $v){
        $this->$k = $v;
      }
    }
    
    $this->ISCOMPLETE = 1;
    $this->PSHIP = 4;
    $this->PIPACK = 4;
    $this->PEPACK = 4;
    $this->dbfSave();

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

//public function webheadSchema($table){ $table->unique('REMOTEADDR'); return $table;	}

public static function deleteCart($_, $args, $request){

      $user = $request->user();  
      $run = false;

      if($user === null){
        return new \App\Models\User;
      }
    
      $cart = static::where('id', $args['id'])->where('KEY', $user->KEY)->first();

      if($cart !== null){

        if($user->vendor->cartsCount <= 1){
          $run = true;
        }

        foreach($cart->items() AS $item){
          $item->dbfDelete();
        }
        $cart->dbfDelete();
      }

      if($run){
          $attributes = ["input"=>[]];
          $newcart = static::dbfUpdateOrCreate(false, $attributes, $request);
      }

      return $user;
  }

    public function updateMyCart($_, $args, $user = false){
      

    
    if(isset($args['input']['id'])){
      $cart = static::where('id', $args['input']['id'])->where('KEY', $user->KEY)->first();
    }else if(isset($args['input']['REMOTEADDR'])){
      $cart = static::where('REMOTEADDR', $args['input']['REMOTEADDR'])->where('KEY', $user->KEY)->first();
    }else{
      $cart = static::newCart($user, $args["input"], true);
    }

      

      foreach($args['input'] AS $k=>$v){
        $cart->$k = $v;
      }
      return $cart->dbfSave();
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
          //
        });

        static::updating(function ($model) {
            //$model = static::prepareUpdateCartTitle($model);
        });

        static::deleted(function ($model) {
           //$model->dbfDelete();
        });
    }

}