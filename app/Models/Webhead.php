<?php namespace App\Models;

use App\Traits\DbfTableTrait;
use App\Traits\DbfValidationTrait;

class Webhead extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\HeadTrait;
  use DbfTableTrait;
  use DbfValidationTrait;

  public $fillable = ["INDEX","KEY","ATTENTION", "DATE","BILL_1","BILL_2"."BILL_3","BILL_4","COMPANY","STREET","CITY","STATE","POSTCODE","VOICEPHONE","OSOURCE","ISCOMPLETE", "ROOM","DEPT","COUNTRY","FAXPHONE","EMAIL","SENDEMCONF","PO_NUMBER","CINOTE","CXNOTE","TRANSNO","DATESTAMP","TIMESTAMP","LASTDATE","LASTTIME","LASTTOUCH","REMOTEADDR","DELETED"];

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

  public function prepCartArgs($args, $user){

    if(!$user || !$user === null || !$user->vendor){
      throw new \ErrorException(
          'VALIDATION FAILED. User or Vendor data missing to prepare cart properties.'
        );
    }

    /* flatten any values from input */
    if(isset($args['input'])){
      foreach($args['input'] AS $key=>$val){
        $newCart->$key = $val;
      }
      unset($args['input']);
    }

    /* MAKE SURE ARGS HAVE ISCOMPLETE */
    if(!array_key_exists('ISCOMPLETE', $args) || $args['ISCOMPLETE'] === "" || $args['ISCOMPLETE'] === ""){
      $args["ISCOMPLETE"] = false;
    }

    /* MAKE SURE ARGS HAVE OSOURCE */
    if(!array_key_exists('OSOURCE', $args) || $args['OSOURCE'] === "" || $args['OSOURCE'] === ""){
      $args["OSOURCE"] = "INTERNET ORDER";
    }

    /* MAKE SURE ARGS HAVE REMOTEADDR */
    if(!array_key_exists('REMOTEADDR', $args) || $args['REMOTEADDR'] === "" || $args['REMOTEADDR'] === ""){
      $uid=  time();//uniqid();
      $zip = substr($user->KEY,0,5);
      $args["REMOTEADDR"] = $uid . $zip;
    }

    /* MAKE SURE ARGS HAVE DATE && TIME INFO */
    /*
    DATE = 20220126
    DATESTAMP = 20220126
    TIMESTAMP = 10:57:17
    LASTDATE = 20220126
    LASTTIME = 10:57:17
    
    */
    $now = \Carbon\Carbon::now();

    if(!array_key_exists('DATE', $args) || $args['DATE'] === "" || $args['DATE'] === ""){
      $args["DATE"] = $now->format("Ymd");
    }
    if(!array_key_exists('DATESTAMP', $args) || $args['DATESTAMP'] === "" || $args['DATESTAMP'] === ""){
      $args["DATESTAMP"] = $now->format("Ymd");
    }
    if(!array_key_exists('LASTDATE', $args) || $args['LASTDATE'] === "" || $args['LASTDATE'] === ""){
      $args["LASTDATE"] = $now->format("Ymd");
    }
    if(!array_key_exists('TIMESTAMP', $args) || $args['TIMESTAMP'] === "" || $args['TIMESTAMP'] === ""){
      $args["TIMESTAMP"] = $now->format("h:i:s");
    }
    if(!array_key_exists('LASTTIME', $args) || $args['LASTTIME'] === "" || $args['LASTTIME'] === ""){
      $args["LASTTIME"] = $now->format("h:i:s");
    }

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

    if(!array_key_exists('KEY', $args) || $args['KEY'] === "" || $args['KEY'] === ""){
      $args["KEY"] = $user->KEY;
    }
    if(!array_key_exists('ORDEREDBY', $args) || $args['ORDEREDBY'] === "" || $args['ORDEREDBY'] === ""){
      $args["ORDEREDBY"] = $user->EMAIL;
    }
    if(!array_key_exists('LASTTOUCH', $args) || $args['LASTTOUCH'] === "" || $args['LASTTOUCH'] === ""){
      $args["LASTTOUCH"] = $user->EMAIL;
    }
    if(!array_key_exists('BILL_1', $args) || $args['BILL_1'] === "" || $args['BILL_1'] === ""){
      $args["BILL_1"] = $user->vendor->ORGNAME;
    }
    if(!array_key_exists('BILL_2', $args) || $args['BILL_2'] === "" || $args['BILL_2'] === ""){
      $args["BILL_2"] = "c/o " . $user->vendor->FIRST . " " . $user->vendor->LAST;
    }
    if(!array_key_exists('BILL_3', $args) || $args['BILL_3'] === "" || $args['BILL_3'] === ""){
      $args["BILL_3"] = $user->vendor->STREET;
    }
    if(!array_key_exists('BILL_4', $args) || $args['BILL_4'] === "" || $args['BILL_4'] === ""){
      $args["BILL_4"] = $user->vendor->CITY . ", " . $user->vendor->STATE . " " . $user->vendor->ZIP5;
    }
    if(!array_key_exists('COMPANY', $args) || $args['COMPANY'] === "" || $args['COMPANY'] === ""){
      $args["COMPANY"] = $user->vendor->ORGNAME;
    }
    if(!array_key_exists('STREET', $args) || $args['STREET'] === "" || $args['STREET'] === ""){
      $args["STREET"] = $user->vendor->STREET;
    }
    if(!array_key_exists('CITY', $args) || $args['CITY'] === "" || $args['CITY'] === ""){
      $args["CITY"] = $user->vendor->CITY;
    }
    if(!array_key_exists('STATE', $args) || $args['STATE'] === "" || $args['STATE'] === ""){
      $args["STATE"] = $user->vendor->STATE;
    }
    if(!array_key_exists('POSTCODE', $args) || $args['POSTCODE'] === "" || $args['POSTCODE'] === ""){
      $args["POSTCODE"] = $user->vendor->ZIP5;
    }
    if(!array_key_exists('VOICEPHONE', $args) || $args['VOICEPHONE'] === "" || $args['VOICEPHONE'] === ""){
      $args["VOICEPHONE"] = $user->vendor->VOICEPHONEL;
    }

    return $args;
  }

	public static function newCart($user, $args, $returnCart = false){
    //\DB::enableQueryLog();
      $newCart = new \App\Models\Webhead;
      $args = $newCart->prepCartArgs($args,$user);
      $newCart->validate($args);
      $dbf_record = $newCart->getDbfTable()->newRecord($args);
      $dbf_record->save();
      dd($dbf_record);

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