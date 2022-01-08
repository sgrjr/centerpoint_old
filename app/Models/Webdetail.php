<?php namespace App\Models;
use \App\Traits\DbfTableTrait;
use \App\Models\Webhead;
use \App\Models\Inventory;

class Webdetail extends BaseModel implements \App\Interfaces\ModelInterface {

	use \App\Ask\AskTrait\DetailTrait;
  use DbfTableTrait;
   
   	public $timestamps = false;
	protected $table = "webdetails";

	  protected $seed = [
    'dbf_webdetail'
  ];

	protected $appends = [];
      protected $attributeTypes = [ 
        "_config"=>"webdetail",
      ];

    protected $fillable = ["REQUESTED", "REMOTEADDR", "PROD_NO", "INDEX", "KEY"];

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

	//responding to events
public static function prepareUpdateCartTitle($model){
  return $model;
}

public static function prepareNewCartTitle($model){

      $user = request()->user();

      if($model->REMOTEADDR === false || $model->REMOTEADDR === ""){
        $cart = \App\Models\Webhead::newCart($user, [], true);
        $model->REMOTEADDR = $cart->REMOTEADDR;
      }

      $model->KEY = $user->KEY;
      $model->SHIPPED = 0;

      $bookAtts = ["ARTICLE","TITLE","AUTHOR","LISTPRICE","STATUS","AUTHORKEY","TITLEKEY","FORMAT","SERIES","PUBLISHER","CAT","PAGES","PUBDATE","INVNATURE","SOPLAN"];
      $book = Inventory::where('ISBN', $model->PROD_NO)->first();
      
      $viewerTitleData = $book->getUserData($user);
      
      foreach($bookAtts AS $att){
        $model->$att = $book->$att;
      }
     
      $model->LISTPRICE = round(floatval($model->LISTPRICE),2);
      $model->SALEPRICE = $viewerTitleData->price;
      $model->DISC = $viewerTitleData->discount;
      $model->DATE = \Carbon\Carbon::now()->format("Ymd"); //20171205
      $model->DATESTAMP = \Carbon\Carbon::now()->format("Ymd"); //20171208
      $model->LASTDATE = \Carbon\Carbon::now()->format("Ymd"); //20171208
      $model->TIMESTAMP = \Carbon\Carbon::now()->format("H"); //12:17:07
      $model->LASTTIME = \Carbon\Carbon::now()->format("H"); //12:17:07

      $model->ORDEREDBY = $user->SNAME;//stephanieiberer   
      $model->LASTTOUCH = $user->SNAME; //stephanieiberer
      $model->COMPUTER = $user->SNAME; //stephanieiberer
      $model->USERPASS = null; //disabled as returns TOO LONG error Why whould UPASS be needed here anyhow? $user->UPASS;       

      return $model;
}
	protected static function boot()
    {
        parent::boot();

        Webdetail::creating(function ($model) {
            $model = static::prepareNewCartTitle($model);
        });

        Webdetail::saved(function ($model) {
        	if(!isset($model->INDEX)){
            	$model->INDEX = $model->dbfSave();
            	$model->save();
        	}else{
        		$model->dbfSave();
        	}
        });

        Webdetail::updating(function ($model) {
            $model = static::prepareUpdateCartTitle($model);
        });

        Webdetail::deleted(function ($model) {
           $model->dbfDelete();
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
