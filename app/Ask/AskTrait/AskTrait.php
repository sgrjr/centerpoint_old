<?php namespace App\Ask\AskTrait;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Config, Schema;
use App\Events\ItemWasAddedToCart;
use App\Events\CartItemWasUpdated;
use App\Events\FailedWritingToDbf;
use App\Events\NewDbfEntryCreated;
use App\Events\ExistingDbfEntryUpdated;
            
trait AskTrait {

    public $changedProperties;

    public function getChangedProperties(){
        return $this->changedProperties;
    }
    public function updateDbf($propertyName, $value){
        $this->changedProperties[$propertyName] = $value;
        return $this;
    }
    public static function xbaseQueryBuilder($writable, $import)
    {
        $root = new static;
       return new \App\Ask\XbaseQueryBuilder($root, $writable, $import);
    }

   public static function eloquentQueryBuilder($root)
    {
       return new \App\Ask\EloquentQueryBuilder($root);
    }

    public static function xmlQueryBuilder($root)
    {
       return new \App\Ask\XmlQueryBuilder($root);
    }

 public function dbfDelete()
    {
        $this->DELETED = true;
        $result = $this->dbfSave();
        if($result){$this->save();}
        return true;
    }

 public function dbfSave()
    {
        $table = $this->xTable();
        $table->open();
        $atttributes_from_dbf = $table->save($this->toArray());
        $table->close();
        $this->update($atttributes_from_dbf);
        return $this;
    }

public static function dbfCreate(){

}

public static function dbfUpdateOrCreate($graphql_root, $attributes, $request=false, $x=false, $user=false) {
    $isNewEntry = true;

     if(isset($request) && $request !== false && $user === false){
      $user = $request->user();
     } else if($user === false){
      $user = request()->user();
     }

     if(isset($attributes["input"])){$attributes = $attributes["input"];}

     //Setting the Model
     if(static::class === "App\Models\Webdetail" && !isset($attributes["id"]) ){
             
         if(!isset($attributes["REMOTEADDR"])){// if vendor has no carts then create one.
              $newcart = \App\Models\Webhead::newCart($user->vendor);
              $newcart->save();
              $newcart->dbfSave();

            $attributes['REMOTEADDR'] = $newcart->REMOTEADDR;
            $attributes['KEY'] = $newcart->KEY;
        }

        //If this is a title being added to the order than we need to check if the PROD_NO already exists or not
        // on the order with REMOTEADDR made by user with KEY.
        $model = $user->vendor->webdetailsOrders()->where('REMOTEADDR',$attributes["REMOTEADDR"])->where("PROD_NO",$attributes["PROD_NO"])->first();
        if(!$model || $model === null){
            //If the title wasn't already on the order then just create a new order item.
            $model = (new static($attributes))->fillAttributes($user);
            $model->save();
            ItemWasAddedToCart::dispatch($model, $user);
        }else{
            $isNewEntry = false;
            //Was already on order so update model attributes with the passed new attributes.
            foreach($attributes AS $k=>$v){
                if($k === "REQUESTED"){
                    $model->$k = $model->$k+$v;
                }else{
                    $model->$k = $v;
                }
            }
            CartItemWasUpdated::dispatch($model, $user);
        }

     }else{
        
        //Check if $attributes do not have an id and therefore create a new $model;
         if(!isset($attributes["id"])){
            $model = (new static($attributes))->fillAttributes($user);
            $model->save();
         }else{
            //$attributes['id'] was set and therefore the $model already exists so query it.
            $model = static::where('id', $attributes['id'])->where('KEY', $user->KEY)->first(); 
            $isNewEntry = false; 
         }

         if($model === null){
            $isNewEntry = true;
            unset($attributes["id"]);
            $model = (new static($attributes))->fillAttributes($user);
         }else{
            foreach($attributes AS $k=>$v){
                $model->$k = $v;
            }
         }
    }       
            
     if($model){
        $model->dbfSave();

        //Check which event to fire
        if($isNewEntry){
            NewDbfEntryCreated::dispatch($model, $user);
        }else{
            ExistingDbfEntryUpdated::dispatch($model, $user);
        }    

     }else{
        \App\Helpers\Misc::dbfLog('Could not write to dbf and or database. There is probably now a blank entry in DBF because of this function fail. ' . static::class . " attributes: " . json_encode($attributes));
        FailedWritingToDbf::dispatch($model, $user);
     }
     return $user;
}

public function fillAttributes($user = false){return $this;}

public function setIfNotSet($key, $val, $force = false, $func_arg = false){

    if($force || !isset($this->$key) || $this->$key === null || $this->$key === false){
        if(method_exists($this,$val)){
            $this->$key = $this->$val($func_arg);
        }else{
            $this->$key = $val;
        }
    }
    return $this;
}

    public static function ask($writable = false, $import = false){

        $model = new static();      

        if(Schema::hasTable($model->getTable()) && $model->count() >= 1 ){
            return static::eloquentQueryBuilder($model);
        }else if($model->source === "XML"){
            return static::csvQueryBuilder($model);
        }else {
            return static::xbaseQueryBuilder($writable, $import);
        }

    }


    public static function dbf($writable = false, $import = false){
        $model = new static;
        return $model->xbaseQueryBuilder($writable, $import);
    }

    public function xTable($skip_memo = false, $writable = true){
        foreach($this->getSeeds() AS $seed){
            if($seed["type"] === "dbf"){
                $name = $seed["path"];
                return new \App\Ask\DatabaseType\XBaseTable($name, $skip_memo, $writable);
            }
        }

        return false;
    }

}