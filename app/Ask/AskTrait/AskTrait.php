<?php namespace App\Ask\AskTrait;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Ask\DatabaseType\PHPXbase\XBaseWritableTable as WritableTable;
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
        return $table->save($this->serialize(), $this->INDEX, isset($this->INDEX) && $this->INDEX !== null);
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

    public function getDbfTable(){
        $table = false;

        foreach($this->getSeeds() AS $seed){

            if($seed["type"] === "dbf"){
                $table = new WritableTable($seed["path"]);
            }  

        }
        $table->open();
        return $table;
    }

    public function serialize(){
        $dbf = $this->getDbfTable()->newRecord( $this->toArray() );
        return $dbf->serialize();
    }

}