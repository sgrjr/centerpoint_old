<?php namespace App\Ask\AskTrait;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Ask\DatabaseType\PHPXbase\XBaseWritableTable as WritableTable;
use Config, Schema;

trait AskTrait {

    public static function xbaseQueryBuilder($root, $writable, $import)
    {
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

        // If the model already exists in the database we can just delete our record
        // that is already in this database using the current IDs in this "where"
        // clause to only update this model. Otherwise, we'll just insert them.
        $table->moveTo((int) $this->INDEX);
        $record = $table->getRecord();
        if ($record !== null) {

            $record->setDeleted(true);
            $table->writeRecord();
        }

        return $this;
    }

 public function dbfSave()
    {
        $table = $this->dbf(true)->getTable();

        if(is_array($table)){$table = $table[0];}

        $table->open();

        $headers = $table->getColumnNames();
        
        // If the model already exists in the database we can just update our record
        // that is already in this database using the current IDs in this "where"
        // clause to only update this model. Otherwise, we'll just insert them.

        $table->moveTo((int) $this->INDEX);
        $record = $table->getRecord();

        if ($this->INDEX !== null && $record !== null) {

            foreach($this->attributes AS $columnName => $value){
                if(strtolower($columnName) !== "index" && in_array($columnName, $headers)) {
                 $record->setObjectByName($columnName,$value);
                }
            }

            $table->writeRecord();

           return $this->INDEX;
        }

        // If the model is brand new, we'll insert it into our database and set the
        // ID attribute on the model to the value of the newly inserted row's ID
        // which is typically an auto-increment value managed by the database.
        else {
 
	        if ($this->fireModelEvent('creating') === false) {
	            return false;
	        }

            /* insert new data */
            $r = $table->appendRecord();
           
            foreach($this->attributes AS $key=>$value){

                if(strtolower($key) !== "index" && in_array($key, $headers)) {
                    $r->setObjectByName($key,$value);
                }
            }

            $table->writeRecord();

	        // We will go ahead and set the exists property to true, so that it is set when
	        // the created event is fired, just in case the developer tries to update it
	        // during the event. This will allow them to do so and run an update here.
	        //$this->exists = true;
	        $this->wasRecentlyCreated = true;
	        //$this->fireModelEvent('created', false);
	        $saved = $table->getRecordCount()-1;
        }

        if ($saved) {
            //$this->finishSave($options);
        }
        
        $table->close();

        return $saved;
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
            return static::xbaseQueryBuilder($model, $writable, $import);
        }

    }


    public static function dbf($writable = false, $import = false){
        $model = new static;
        return static::xbaseQueryBuilder($model, $writable, $import);
    }

    public static function getDbfTable(){
        $model = new static;
        $table = false;

        foreach($model->getSeeds() AS $seed){

            if($seed["type"] === "dbf"){
                $table = new WritableTable($seed["path"]);
            }  

        }
        $table->open();
        return $table;
    }

}

