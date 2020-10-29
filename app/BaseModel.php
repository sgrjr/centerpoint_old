<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Config, Schema;
use App\Ask\AskTrait\AskTrait;
use App\Core\ModelTrait;
use App\Core\ManageTableTrait;
use App\Core\PresentableTrait;

use App\Core\PresentableTrait;

class BaseModel extends Model
{
<<<<<<< HEAD
	use AskTrait, ManageTableTrait, ModelTrait, PresentableTrait;
=======

	use AskTrait, PresentableTrait;

	protected $memo = "needs a Memo";
    protected $presenter = 'App\Presenters\DbfPresenter';

    public function isFromDbf(){
        if(is_array($this->getSeed())){return true;}
        return strpos(strtolower($this->getSeed()), ".dbf") !== false;
    }

    public function getMemo(){
        $config = Config::get("cp");
        $tablename = $this->getTable();
        return $config["tables"][$tablename]["memo"];
    }

    public function getUrlRootAttribute(){
        $config = Config::get("cp");
        $tablename = $this->getTable();
        return $config["tables"][$tablename]["urlroot"];
    }

    public function getIndexAttribute(){
        if(isset($this->attributes["INDEX"])){
            return $this->attributes["INDEX"];
        }else if(isset($this->attributes["index"])){
            return $this->attributes["index"];
        }

        return null;
        
    }

    public function getPropertiesAttribute(){
        $dbf = \App\DBF::where("name",$this->tableSafeName)->first();
        if($dbf === null){
            return new \App\DBF;
        }

        return $dbf;
    }

    public function getSourceAttribute(){
        
        if(is_array($this->getSeed())){return "DBF";}

        $isDbf = strpos(strtolower($this->getSeed()), ".dbf");

        if($isDbf){ return "DBF";}

        $isCsv = strpos(strtolower($this->getSeed()), ".xml");
        if($isCsv){ return "XML";}

        return "SEED";

    }

    public function getTableExistsAttribute(){
        return \Schema::hasTable($this->tableSafeName);
    }

    public function getTableSafeNameAttribute(){
       return $this->getTable();
    }

    public function manager(){
        return TableManager::load($this);
    }

    public function getDbfPath(){

        if($this->getSeed() === false){
            return false;
        }
          return $this->getSeed();  
    }

    public function getDbfPrimaryKey(){
        if($this->getSeed() === false){
            return false;
        }

        return $this->dbfPrimaryKey? $this->dbfPrimaryKey:$this->primaryKey;
    }

    public function getSeed(){
        $config = Config::get("cp");
        $tablename = $this->getTable();
        return $config["tables"][$tablename]["seed"];
    }

     public function getAltColumn($record, $att){

        if(isset($record[$att]) ){
            return $record[$att];
        }else{
            return null;
        }
    }

    public function route($type = ""){
        if($type !== ""){$type = "/".$type;}
        return $type . '/' . $this->getTable();
    }

    public static function ask($writable = false){

        $model = new static;

        if(Schema::hasTable($model->getTable()) && $model->count() >= 2 ){
            return static::eloquentQueryBuilder($model);
        }else if($model->source === "XML"){
            return static::csvQueryBuilder($model);
        }else {
            return static::xbaseQueryBuilder($model, $writable);
        }

    }

    public static function dbf($writable = false){
        $table = new static;

        if($table->getSeed() === false || $table->getSeed() === null || $table->getSeed() === "" || $table->getSeed() === "Config"){
            return false;
        }

        return static::xbaseQueryBuilder($table, $writable);
    }

    public static function mysql(){
        return static::eloquentQueryBuilder(new static);
    }

    public static function xml(){
        return static::xmlQueryBuilder(new static);
	}

    public static function getIndexes(){
        return [];
	}
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
}
