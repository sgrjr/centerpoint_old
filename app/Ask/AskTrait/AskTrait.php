<?php namespace App\Ask\AskTrait;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Ask\DatabaseType\PHPXbase\XBaseTable;
use Config, Schema;

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
        $table = $this->dbf(true)->getTable();
        if(is_array($table)){$table = $table[0];}
        $result = $table->delete($this);
        if($result){$this->delete();}
        return true;
    }

 public function dbfSave()
    {
        $table = $this->dbf(true)->getTable();
        if(is_array($table)){$table = $table[0];}
        $model = $table->save($this->serialize(), $this);
        $model->save();
        return $model;
    }

public static function dbfUpdateOrCreate($graphql_root, $attributes, $request=false, $x=false, $user=false) {
    
     if(isset($request) && $request !== false && $user === false){
      $user = $request->user;
     } else if($user === false){
      $user = request()->user;
     }

     if(isset($attributes["input"])){$attributes = $attributes["input"];}

     if(!isset($attributes["id"])){
        $model = (new static($attributes))->fillAttributes($user);
     }else{
        $model = static::where('id', $attributes['id'])->where('KEY', $user->KEY)->first();
     }

     if($model === null){
        unset($attributes["id"]);
        $model = (new static($attributes))->fillAttributes($user);
     }else{
        foreach($attributes AS $k=>$v){
            $model->$k = $v;
        }
     }

     $model = $model->dbfSave();
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

/*
    public function create(array $attributes = [])
    {
        $model = new static($attributes);
        return $model;
    }
*/

    public function findByIndex($index)
    {
        return  (new \App\Ask\QueryBuilder($this))->index($index);
    }

    public function raw()
    {
        return  (new \App\Ask\XbaseQueryBuilder($this))->index($this->INDEX);
    }

    public function getCount(){
        $x = new \stdclass;
        $x->mysql = 0;
        $x->dbf = 0;

        if($this->isFromDbf()){

            $x->dbf = $this->dbf()->count();

             if(\Schema::hasTable($this->getTable())){
                $x->mysql = $this->count();
             }

        }else if(\Schema::hasTable($this->getTable())){
            $x->mysql = $this->count();
        }else if($this->source === "CSV"){
            $x->dbf = $this->csv()->count();
        }

        return $x;
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

    public function serialize(){
        $deleted = false;
        $index = false;
        
        $attributes = $this->toArray();
        if(isset($attributes["DELETED"])){
            $deleted = $attributes["DELETED"];
            unset($attributes["DELETED"]);
        }
        
      if(isset($attributes["INDEX"])){
        $index = $attributes["INDEX"];
        unset($attributes["INDEX"]);
      }
        
        $dbf = $this->dbf()->getTable()[0]->newRecord( $attributes, $deleted, $index );
        return $dbf->serialize();
    }

}