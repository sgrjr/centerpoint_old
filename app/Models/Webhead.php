<?php namespace App\Models;

use App\Models\Traits\DbfTableTrait;
use App\Models\Traits\DbfValidationTrait;

//Events (shouuld move all this kind of logic elsewhere sometime)
//it is certianly overloading these models

use App\Events\CartWasSubmitted;

class Webhead extends BaseModel implements \App\Models\Interfaces\ModelInterface {

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
      ->setIfNotSet('ORDEREDBY',$user->UNAME)
      ->setIfNotSet('EMAIL',$user->EMAIL)
      ->setIfNotSet('USERPASS',$user->user_pass_unsafe)
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
      ->setIfNotSet('VOICEPHONE',$user->vendor->VOICEPHONE)
      ->setIfNotSet('PSHIP', 7)
      ->setIfNotSet('PIPACK', 7)
      ->setIfNotSet('PEPACK', 7);
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
    $this->PSHIP = 5;
    $this->PIPACK = 5;
    $this->PEPACK = 5;
    $this->dbfSave();
    
    CartWasSubmitted::dispatch(request(), $this);

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
          $newcart = static::newCart($user->vendor);
          $newcart = $newcart->dbfSave();
          if($newcart){
            $newcart->save();
          }
      }

      return $user;
  }

public static function newCart($vendor){
      $uid=  uniqid();
      $zip = substr($vendor->KEY,0,5);

      $REMOTEADDR = substr($zip . "." . $uid, 0,15);
      $mytime = \Carbon\Carbon::now()->format("Ymd");

      $newCart = new static;
      $newCart->REMOTEADDR = $REMOTEADDR;
      $newCart->KEY = $vendor->KEY;
      
      $newCart->DATE = $mytime;

      // to get values for: 
      //BILL_1, BILL_2, BILL_3, BILL_4, BILL_5, COMPANY, ATTENTION, STREET, ROOM, DEPT, CITY, STATE, POSTCODE

      //1. Check for most recent entry for vendor in Brohead (NOTE: Skip over matches where OSOURCE != "DAILY_ORDERS")
      $recentOrder = $vendor->broOrders()->where('OSOURCE', "LIKE", "%DAILY_ORDERS%")->orderBy('id','DESC')->first();

      if($recentOrder === null){
        //2. If no entry in Brohead then Check for most recent entry in Allhead (SAME NOTE AS in #1)
        $recentOrder = $vendor->allOrders()->where('OSOURCE', "LIKE", "%DAILY_ORDERS%")->orderBy('id','DESC')->first();
      }
      
      if($recentOrder !== null){
        $newCart = static::initCartFromHead($newCart, $recentOrder);
      }else{
        //3. Create Cart from vendor if no orders were found in Brohead or Allhead
        $newCart = static::initCartFromVendor($newCart, $vendor);
      }
      
      $newCart->VOICEPHONE =  $vendor->VOICEPHONE;
      $newCart->FAXPHONE =  $vendor->FAXPHONE;
      $newCart->EMAIL = $vendor->EMAIL;
      $newCart->OSOURCE = "INTERNET ORDER";
      $newCart->ISCOMPLETE = false;
      //\Session::put("use_cart",$REMOTEADDR);
      return $newCart;
  }
  // function modifies $newCart by adding values for
  // BILL_1, BILL_2, BILL_3, BILL_4, BILL_5, COMPANY, ATTENTION, STREET, ROOM, DEPT, CITY, STATE, POSTCODE
  public static function initCartFromVendor($newCart, $vendor){
      $newCart->BILL_1 = trim($vendor->ARTICLE) . " " . trim($vendor->ORGNAME); // trim(ARTICLE)+ " " trim(ORGNAME)
      $newCart->BILL_2 = $vendor->STREET;
      
      if(trim($vendor->SECONDARY != "")){
        //a) If there is an entry in vendor->SECONDARY
        $newCart->BILL_3 = $vendor->SECONDARY;
        $newCart->BILL_4 = trim(trim($vendor->CARTICLE) . " " . trim($vendor->CITY) . ", " . $vendor->STATE . " " . $vendor->ZIP5);
        $newCart->ATTENTION = $vendor->SECONDARY;
      }else{
        //b) if no entry in vendor->SECONDARY
        $newCart->BILL_3 = trim(trim($vendor->CARTICLE) . " " . trim($vendor->CITY) . ", " . $vendor->STATE . " " . $vendor->ZIP5);
        $newCart->BILL_4 = "";
        $newCart->ATTENTION = $vendor->SECONDARY;
      }
      $newCart->BILL_5 = "";
      $newCart->ROOM = "";
      $newCart->DEPT = "";
      $newCart->COMPANY = trim(trim($vendor->ARTICLE) . " " . trim($vendor->ORGNAME));
      $newCart->STREET =  $vendor->STREET;
      $newCart->CITY = trim(trim($vendor->CARTICLE) . " " . trim($vendor->CITY));
      $newCart->STATE = $vendor->STATE;
      $newCart->POSTCODE =  $vendor->ZIP5;

    return $newCart;
  }
  // function modifies $newCart by adding values for
  // BILL_1, BILL_2, BILL_3, BILL_4, BILL_5, COMPANY, ATTENTION, STREET, ROOM, DEPT, CITY, STATE, POSTCODE
    public static function initCartFromHead($newCart, $head){
      $newCart->BILL_1 = trim($head->BILL_1);
      $newCart->BILL_2 = trim($head->BILL_2);
      $newCart->BILL_3 = trim($head->BILL_3);
      $newCart->BILL_4 = trim($head->BILL_4);
      $newCart->BILL_5 = trim($head->BILL_5);
      $newCart->COMPANY = trim($head->COMPANY);
      $newCart->ATTENTION = trim($head->ATTENTION);
      $newCart->STREET = trim($head->STREET);
      $newCart->ROOM = trim($head->ROOM);
      $newCart->DEPT = trim($head->DEPT);
      $newCart->CITY = trim($head->CITY);
      $newCart->STATE = trim($head->STATE);
      $newCart->POSTCODE = trim($head->POSTCODE);

    return $newCart;
  }

    public function getMyCart($_, $args){

        $user = request()->user();

        if(isset($args['id'])){
            $cart = static::where('id', $args['id'])->where('KEY', $user->KEY)->where('DELETED', '0')->first();
        }else{
            $cart = static::where('REMOTEADDR', $args['REMOTEADDR'])->where('KEY', $user->KEY)->where('DELETED', '0')->first();
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