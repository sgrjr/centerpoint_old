<?php namespace App;
use \App\Core\DbfTableTrait;
class Webhead extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\HeadTrait;
  use DbfTableTrait;

	protected $appends = [];
	protected $table = "webheads";

	protected $dbfPrimaryKey = 'REMOTEADDR';
    protected $seed = [
    'dbf_webhead'
  ];

  protected $attributeTypes = [ 
    "_config"=>"webhead",
  ];


  // $record passed to getDetailsConnection must be an associative array
  // resulting from XBaseRecord->getRawData()

  public function items(){
    return $this->hasMany('\App\Webdetail','REMOTEADDR','REMOTEADDR');
  }

  public function vendor(){
    return $this->belongsTo('\App\Vendor','KEY','KEY');
  }

  public function getVendorConnection(array $record = []){

    if(empty($record)){
      $key = $this->getAttributes()["KEY"];
    }else{
      $key = $record["KEY"];
    }
    
    if(strpos($key,"04046") !== false){
      $vendor = new \App\Vendor;
      $vendor->KEY = $key;
      $vendor->ORGNAME = "FAKE COMPANY";
      return $vendor;
    }else{
      return \App\Vendor::ask()->where("KEY","===", $key)->first();
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
      
      $this->saveChanges();
      return $this;
    }


	public static function newCart($user, $args){
	    $uid=  time();//uniqid();
      $zip = substr($user->KEY,0,5);
      $REMOTEADDR =  $uid . $zip;
      $mytime = \Carbon\Carbon::now()->format("Ymd");
      $newCart = new static;
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
      $newCart->ISCOMPLETE = "F";

      foreach($args['input'] AS $key=>$val){
        $newCart->$key = $val;
      }

      $newCart->saveToDbf();

      return $user;
	}

  public function submitOrder($props = false){
    //$record->ISCOMPLETE = "1";
    //$record->saveChanges();
    //$record->deleteRecord();

    //1. get most recent transno
    //2. create brohead record-
    //3. create identical titles in brodetails as webdetails

    /*
    $to = [];


    $classes = ["\App\AncientHead","\App\AllHead","\App\BackHead","\App\BroHead"];

    foreach($classes AS $class){
      $count = $class::dbf()->table->recordCount;
      $list = $class::dbf()->setIndex($count-50)->setPerPage(100)->all();

        foreach($list->records AS $record){
          $to[$record->TRANSNO] = $record->TRANSNO;
        }

    }
    arsort($to);
    $transno = array_key_first ($to)+1;

    $this->TRANSNO = $transno;
    $this->ISCOMPLETE = true;

    $head = $this->getAttributes();
    $details = $this->itemsArray()->toArray();
    unset($head["INDEX"]);
    $head["TRANSNO"] = $transno;

    $brohead = new \App\BroHead($head);

    $brohead->saveChanges();

    foreach($details AS $detail){
      unset($detail["INDEX"]);
      $detail["TRANSNO"] = $transno;

      $det = new \App\BroDetail($detail);

      $det->saveChanges();
    }

    $this->saveChanges();

    foreach($this->items AS $item){
      $item->deleteRecord();
    }

    $this->deleteRecord();
    */

    if($props){
      foreach($props AS $k => $v){
        $this->$k = $v;
      }
    }
    
    $this->ISCOMPLETE = "T";
    $this->saveChanges();

    return $this;
  }

  public function deleteFromCart($isbn){
    foreach($this->items AS $item){
      if($item->PROD_NO === $isbn){
        $item->deleteRecord();
      }
    }
    return $this;
  }
  
  public function addToCart($user, $isbn, $qty){

   foreach($this->getDetailsConnection()->data AS $detail){
     if($detail->PROD_NO === $isbn){
       $detail->REQUESTED = $detail->REQUESTED + 1;
       $detail->saveToDbf();
       return $this;
     }
   }


    $detail = new \App\WebDetail;
    $detail->REQUESTED = $qty;
    $detail->REMOTEADDR = $this->REMOTEADDR;
    $detail->PROD_NO = $isbn;
    $detail->KEY = $user->KEY;
    $detail->SHIPPED = 0;

    $bookAtts = ["ARTICLE","TITLE","AUTHOR","LISTPRICE","STATUS","AUTHORKEY","TITLEKEY","FORMAT","SERIES","PUBLISHER","CAT","PAGES","PUBDATE","INVNATURE","SOPLAN"];
    $book = \App\Inventory::ask()->where('ISBN','===', $isbn)->first();
    
    $viewerTitleData = $book->getUserData($user);
    
    foreach($bookAtts AS $att){
      $detail->$att = $book->$att;
    }
   
    $detail->LISTPRICE = round(floatval($detail->LISTPRICE),2);
    $detail->SALEPRICE = $viewerTitleData->price;
    $detail->DISC = $viewerTitleData->discount;
    $detail->DATE = \Carbon\Carbon::now()->format("Ymd"); //20171205
    $detail->DATESTAMP = \Carbon\Carbon::now()->format("Ymd"); //20171208
    $detail->LASTDATE = \Carbon\Carbon::now()->format("Ymd"); //20171208
    $detail->TIMESTAMP = \Carbon\Carbon::now()->format("H"); //12:17:07
    $detail->LASTTIME = \Carbon\Carbon::now()->format("H"); //12:17:07

    $detail->ORDEREDBY = $user->SNAME;//stephanieiberer   
    $detail->LASTTOUCH = $user->SNAME; //stephanieiberer
    $detail->COMPUTER = $user->SNAME; //stephanieiberer
    $detail->USERPASS = $user->UPASS;       

    $detail->saveToDbf();
  
    return $user;
}

public function webheadSchema($table){ $table->unique('REMOTEADDR'); return $table;	}

public function createCartTitle(\Request $request, $input){

      $w = \App\WebHead::dbf()
                ->where("REMOTEADDR", "==",$input["REMOTEADDR"])
                ->first();
        
      $w->addToCart($request->user(), $input['ISBN'], $input['QTY']);

      return $request->user();
}

  public function deleteCartTitle(\Request $request, $input){

        $w = \App\WebHead::dbf()
                  ->where("REMOTEADDR", "==",$input["REMOTEADDR"])
                  ->first();
          
        $w->deleteFromCart($args['ISBN']);

        return $request->user();
  }

  public function updateCartTitle(\Request $request, $input){

      $remoteaddr = $input["REMOTEADDR"];

      $detail = \App\WebDetail::dbf()
            ->where("REMOTEADDR", "==",$remoteaddr)
            ->where("PROD_NO","==", $input['ISBN'])
            ->first();
        
        unset($input["REMOTEADDR"]);
        unset($input["ISBN"]);

        foreach($input AS $k=>$v){
          $detail->$k = $v;
        }

        $d->saveToDbf();

        return $request->user();
  }

  public function createCart($input){
      $request = request();
      if($input === null){$input = [];}

      \App\WebHead::newCart($request->user()->vendor, $input);
      return $request->user();
  }

  public function deleteCart($user, $args){

            $w = \App\WebHead::dbf()
                ->where("REMOTEADDR", "===",$args["input"]["REMOTEADDR"])
                ->where("KEY", "===",$user->KEY)
                ->first();
      
        foreach($w->items AS $item){
            $item->deleteFromDbf();
          }
      
        $w->deleteFromDbf();

        if($user->vendor->cartsCount <= 0){
            $newcart = \App\WebHead::newCart($user->vendor);
        }

      return $user;
  }

  public function updateCart($user, $args){

      foreach($args['input'] AS $key=>$val){
          if($key === "ISCOMPLETE"){
              if($val === true){
                $this->$key = "T";
              }else{
                $this->$key = "F";
              }
          }else{
            $this->$key = $val;
          }
        
      }

      $this->saveToDbf();

        if(isset($input["ISCOMPLETE"])){
          event(new \App\Events\CartWasSubmitted(request(), $this));
        }

      return $user;
  }

}
