<?php namespace App;
use \App\Core\DbfTableTrait;
class WebHead extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\HeadTrait;
  use DbfTableTrait;

	protected $fillable = ["INDEX","KICKBACK","INVQUERY","INVLMNT","PROMONAME","MASTERPASS","MASTERDATE","NEWREMOTE","REMOTEADDR","BITEMS","BPRODUCT","KEY","DATE","TESTTRAN","BILL_1","PSHIP","PIPACK","PEPACK","PINVOICE","NEWPRODUCT","PRODUCT","USERPASS","ORDEREDBY","ITEMS","NEWITEMS","TITEMS","TPRODUCT","SHIPPING","SALESTAX","OTHERDESC","OTHER","FREESHIP","SHIPMETHOD","BILLUPDATE","SHIPUPDATE","MAILUPDATE","ORDUPDATE","BILL_2","BILL_3","BILL_4","BILL_5","COMPANY","ATTENTION","STREET","ROOM","DEPT","CITY","STATE","POSTCODE","COUNTRY","VOICEPHONE","FAXPHONE","EMAIL","SENDEMCONF","PO_NUMBER","COMPUTER","TIMESTAMP","DATESTAMP","LASTTOUCH","LASTDATE","LASTTIME","UPS_KEY","UPSDATE","BILLWEIGHT","PACKAGES","COMMCODE","TERMS","OSOURCE","OSOURCE2","OSOURCE3","OSOURCE4","PAID","PAIDAMOUNT","PAIDDATE","PAYTYPE","SPECIALD","CANBILL","TAXEXEMPT","ISCOMPLETE","SORTORDER","SHIPPER","DATEIN","DATEOUT","TIMEIN","TIMEOUT","HOTBOX","CINOTE","CXNOTE","LASTCHECK","F810SENT","F855NUM","F855SENT","F856SENT","LASTVIEW","CPHOLD","LOGOFFPOST","LOGOFFSAVE","TRANSNO"];

	protected $appends = ["items"];
	protected $table = "webheads";
<<<<<<< HEAD
	protected $dbfPrimaryKey = 'REMOTEADDR';
    protected $seed = [
    'dbf_webhead'
  ];

  protected $attributeTypes = [ 
    "_config"=>"webhead",
  ];
=======
	protected $primaryKey = 'REMOTEADDR';
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

  // $record passed to getDetailsConnection must be an associative array
  // resulting from XBaseRecord->getRawData()
  public function getItemsAttribute(){

<<<<<<< HEAD
   $items = \App\WebDetail::ask()->where("REMOTEADDR","===", $this->REMOTEADDR)->setPerPage(1000);
=======
   $items = \App\Webdetail::ask()->where("REMOTEADDR","===", $this->REMOTEADDR)->setPerPage(1000);
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
   return $items->setData()->data->records;
  }

  public function itemsArray(){

<<<<<<< HEAD
   $items = \App\WebDetail::dbf()->where("REMOTEADDR","===", $this->REMOTEADDR)->setPerPage(1000);
=======
   $items = \App\Webdetail::dbf()->where("REMOTEADDR","===", $this->REMOTEADDR)->setPerPage(1000);
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
   return $items->setData(false, true)->data->records;
  }

	public function getDetailsConnection(array $record = []){

    if(empty($record)){
      $remoteaddr = $this->getAttributes()["REMOTEADDR"];
    }else{
      $remoteaddr = $record["REMOTEADDR"];
    }
		
<<<<<<< HEAD
		return \App\WebDetail::ask()->where("REMOTEADDR","===", $remoteaddr)->setPerPage(1000)->get();
=======
		return \App\Webdetail::ask()->where("REMOTEADDR","===", $remoteaddr)->setPerPage(1000)->get();
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
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

<<<<<<< HEAD
	public static function newCart($vendor, $input = []){
=======
	public static function newCart($vendor){
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
	    $uid=  uniqid();
      $zip = substr($vendor->KEY,0,5);

      $REMOTEADDR = substr($zip . "." . $uid, 0,15);
      $mytime = \Carbon\Carbon::now()->format("Ymd");

      $newCart = new static;

      $newCart->REMOTEADDR = $REMOTEADDR;
      $newCart->KEY = $vendor->KEY;
      
      $newCart->DATE = $mytime;

      $newCart->BILL_1 = $vendor->ORGNAME;
      $newCart->BILL_2 =   "c/o " . $vendor->FIRST . " " . $vendor->LAST;
      $newCart->BILL_3 =   $vendor->STREET;
      $newCart->BILL_4 =   $vendor->CITY . ", " . $vendor->STATE . " " . $vendor->ZIP5;
      $newCart->COMPANY =  $vendor->ORGNAME;
      $newCart->STREET =  $vendor->STREET;
      $newCart->CITY =  $vendor->CITY;
      $newCart->STATE =  $vendor->STATE;
      $newCart->POSTCODE =  $vendor->ZIP5;
      $newCart->VOICEPHONE =  $vendor->VOICEPHONE;
      $newCart->OSOURCE = "INTERNET ORDER";
      $newCart->ISCOMPLETE = "F";
<<<<<<< HEAD

      foreach($input AS $k=>$v){
        $newCart->$k = $v;
      }
=======
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

      $newCart->saveChanges();

      //\Session::put("use_cart",$REMOTEADDR);
      return $newCart;
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

<<<<<<< HEAD
    $classes = ["\App\AncientHead","\App\AllHead","\App\BackHead","\App\BroHead"];
=======
    $classes = ["\App\Ancienthead","\App\Allhead","\App\Backhead","\App\Brohead"];
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

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

<<<<<<< HEAD
    $brohead = new \App\BroHead($head);
=======
    $brohead = new \App\Brohead($head);
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
    $brohead->saveChanges();

    foreach($details AS $detail){
      unset($detail["INDEX"]);
      $detail["TRANSNO"] = $transno;
<<<<<<< HEAD
      $det = new \App\BroDetail($detail);
=======
      $det = new \App\Brodetail($detail);
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
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
  
  public function addToCart($viewer, $isbn, $qty){

   foreach($this->getDetailsConnection()->records AS $detail){
     if($detail->PROD_NO === $isbn){
       $detail->REQUESTED = $detail->REQUESTED + 1;
       $detail->saveChanges();
       return $this;
     }
   }

<<<<<<< HEAD
    $detail = new \App\WebDetail;
    $detail->REQUESTED = $qty;
    $detail->REMOTEADDR = $this->REMOTEADDR;
    $detail->PROD_NO = $isbn;
    $detail->KEY = $viewer->user->KEY;
=======
    $detail = new \App\Webdetail;
    $detail->REQUESTED = $qty;
    $detail->REMOTEADDR = $this->REMOTEADDR;
    $detail->PROD_NO = $isbn;
    $detail->KEY = $viewer->user->key;
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
    $detail->SHIPPED = 0;

    $bookAtts = ["ARTICLE","TITLE","AUTHOR","LISTPRICE","STATUS","AUTHORKEY","TITLEKEY","FORMAT","SERIES","PUBLISHER","CAT","PAGES","PUBDATE","INVNATURE","SOPLAN"];
    $book = \App\Inventory::ask()->where('ISBN','===', $isbn)->first();
    
    $viewerTitleData = $book->getUserData($viewer);
    
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

    $detail->ORDEREDBY = $viewer->user->credentials->SNAME;//stephanieiberer   
    $detail->LASTTOUCH = $viewer->user->credentials->SNAME; //stephanieiberer
    $detail->COMPUTER = $viewer->user->credentials->SNAME; //stephanieiberer
    $detail->USERPASS = $viewer->user->credentials->UPASS;       

    $detail->saveChanges();
  
    return $this;
}

<<<<<<< HEAD
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

      $detail = \App\WebDetail::dbf(true)
            ->where("REMOTEADDR", "==",$remoteaddr)
            ->where("PROD_NO","==", $input['ISBN'])
            ->first();
        
        unset($input["REMOTEADDR"]);
        unset($input["ISBN"]);

        foreach($input AS $k=>$v){
          $detail->$k = $v;
        }

        $d->saveChanges();

        return $request->user();
  }

  public function createCart(\Request $request, $input){
      return \App\WebHead::newCart($request->user()->vendor, $input);
  }

  public function deleteCart(\Request $request, $input){

            $w = \App\WebHead::dbf()
                ->where("REMOTEADDR", "===",$input["REMOTEADDR"])
                ->where("KEY", "===",$request->user()->KEY)
                ->first();
      
        foreach($w->items AS $item){
            $item->deleteRecord();
          }
      
        $w->deleteRecord();

        if($request->user()->vendor->cartsCount <= 0){
            $newcart = \App\WebHead::newCart($request->user()->vendor);
        }

      return $request->user();
  }

  public function updateCart(\Request $request, $input){
          $remoteaddr = $input["REMOTEADDR"];
          unset($input["REMOTEADDR"]);

      $head = \App\WebHead::dbf(true)
            ->where("REMOTEADDR", "==",$remoteaddr)
            ->where("KEY","==", $request->user()->KEY)
            ->first();

        foreach($input AS $k=>$v){
          $head->$k = $v;
        }

        $head->saveChanges();

        if(isset($input["ISCOMPLETE"])){
          event(new \App\Events\CartWasSubmitted($request, $head));
        }

        return $request->user();
  }


=======
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
}
