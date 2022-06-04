<?php namespace App\Models;
use \App\Models\Traits\DbfTableTrait;
use \App\Models\Webhead;
use \App\Models\Inventory;

class Webdetail extends BaseModel implements \App\Models\Interfaces\ModelInterface {

  use \App\Ask\AskTrait\DetailTrait;
  use DbfTableTrait;
   
   	public $timestamps = false;
	protected $table = "webdetails";

	  protected $seed = [
    'dbf_webdetail'
  ];

   protected $indexes = ["KEY"];
	protected $appends = [];
      protected $attributeTypes = [ 
        "_config"=>"webdetail",
      ];

    protected $fillable = ["REQUESTED", "REMOTEADDR", "PROD_NO", "INDEX", "KEY","DELETED"];

    public $foreignKeys = [
        ["REMOTEADDR","REMOTEADDR","webheads"], //REMOTEADDR references REMOTEADDR on webheads
        ["PROD_NO","ISBN","inventories"], //PROD_NO references ISBN on inventories
    ];

    public function scopeNotDeleted($query)
    {
        return $query->where('DELETED', false);
    }
    
    public function getBookConnection(array $record = []){

	    if(empty($record)){
	      $isbn = $this->getAttributes()["PROD_NO"];
	    }else{
	      $isbn = $record["PROD_NO"];
	    }
	    
	    return Inventory::ask()->where("ISBN","===", $isbn)->first();
	  }

	  	public function webdetailSchema($table){$table->foreign('REMOTEADDR')->references('REMOTEADDR')->on('webheads'); return $table;	}

	  	public function getCartAttribute(){
	  		return Webhead::dbf()
                  ->where("REMOTEADDR", "==", $this->REMOTEADDR)
                  ->first();
	  	}

	  public function getCoverArtAttribute(){
	    return url("/img/small/" . $this->attributes['PROD_NO'] . ".jpg");
	  }

	 public function user(){
	    return $this->belongsTo('\App\Models\User','KEY','KEY');
	  }


public function fillAttributes($user = false){

   //fininsh figuring creating and updating carttitles and eventually deleting them
    if(!$user){$user = request()->user();}

    $now = \Carbon\Carbon::now();

    $this
      ->setIfNotSet('REQUESTED', 1)
      ->setIfNotSet('KEY',$user->KEY)
      ->setIfNotSet('REMOTEADDR','getRemoteAddr', false, $user)
      ->setIfNotSet('SHIPPED', 0)
      ->setIfNotSet('PROD_NO',null);

    // Set Attributes Related to Book
    $book = Inventory::where('ISBN', $this->PROD_NO)->first();
    if($book === null){
        return false;
    }
    $bookAtts = ["ARTICLE","TITLE","AUTHOR","LISTPRICE","STATUS","AUTHORKEY","TITLEKEY","FORMAT","SERIES","PUBLISHER","CAT","PAGES","PUBDATE","INVNATURE","SOPLAN"];
    foreach($bookAtts AS $att){
        $this->setIfNotSet($att, $book->$att);
    }

    //Set Attributes Viewer/Vendor Related
    $viewerTitleData = $book->getUserData($user);
    //viewerTitleData is returning an empty object WHY WHY WHY WhY ????

      $this
      ->setIfNotSet('LISTPRICE',round(floatval($book->LISTPRICE),2), true)
      ->setIfNotSet('SALEPRICE',$viewerTitleData->price, true)
      ->setIfNotSet('DISC',$viewerTitleData->discount, true)
      ->setIfNotSet('DATE',\Carbon\Carbon::now()->format("Ymd"))
      ->setIfNotSet('DATESTAMP',\Carbon\Carbon::now()->format("Ymd"))
      ->setIfNotSet('LASTDATE',\Carbon\Carbon::now()->format("Ymd"), true)
      ->setIfNotSet('TIMESTAMP',\Carbon\Carbon::now()->format("H"))
      ->setIfNotSet('LASTTIME',\Carbon\Carbon::now()->format("H"), true)
      ->setIfNotSet('ORDEREDBY',$user->SNAME)
      ->setIfNotSet('LASTTOUCH',$user->SNAME, true)
      ->setIfNotSet('COMPUTER',$user->SNAME)
      ->setIfNotSet('USERPASS',null);//disabled as returns TOO LONG error Why whould UPASS be needed here anyhow? $user->UPASS      

      return $this;
  }

public function getRemoteAddr($user){
    $cart = \App\Models\Webhead::dbfUpdateOrCreate(false, [], false, false, $user);
    return $cart->REMOTEADDR;
}

	protected static function boot()
    {
        parent::boot();

        Webdetail::creating(function ($model) {
            //;
        });

        Webdetail::saved(function ($model) {
        	//
        });

        Webdetail::updating(function ($model) {
           //
        });

        Webdetail::deleted(function ($model) {
           //
        });


        /*
        creating and created: sent before and after records have been created.
		updating and updated: sent before and after records are updated.
		saving and saved: sent before and after records are saved (i.e created or updated).
		deleting and deleted: sent before and after records are deleted or soft-deleted.
		restoring and restored: sent before and after soft-deleted records are restored.
		retrieved: sent after records have been retrieved.
		*/
    }

    public function deleteMyTitleFromCart($_, $args){
    	
    	static::where('id', $args['id'])->where('KEY',request()->user()->KEY)->delete();

    	return request()->user();
    }

    public function addTitleToCart($_, $args){

        if($args["REMOTEADDR"] === "NEW_UNSAVED_CART"){

            $wh = Webhead::newCart(auth()->user(), $args, true);

            $detail = static::create([
                "REQUESTED" => $args["REQUESTED"],
                "PROD_NO" => $args["PROD_NO"],
                "REMOTEADDR" => $wh->REMOTEADDR
            ]);
        }else{

            $head = Webhead::where("REMOTEADDR",$args["REMOTEADDR"])->first();
            $updated = false;

            foreach($head->items AS $item){
                if($item->PROD_NO === $args["PROD_NO"]){
                    $item->REQUESTED = $item->REQUESTED + $args["REQUESTED"];
                    $item->save();
                    $detail = $item;
                    $updated = true;
                }
            }

            if(!$updated){
                $detail = static::create([
                    "REQUESTED" => $args["REQUESTED"],
                    "PROD_NO" => $args["PROD_NO"],
                    "REMOTEADDR" => $args["REMOTEADDR"]
                ]);
            }

        }
        
        return $detail;
    }

}
