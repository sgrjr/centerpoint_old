<?php namespace App\Traits;

use Config, Schema;

Trait ModelTrait
{
	protected $memo = "needs a Memo";
    protected $indexes = [];

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

    public function getTableExistsAttribute(){
        return \Schema::hasTable($this->getTable());
    }

    public function getIgnoreColumns(){
        return $this->ignoreColumns? $this->ignoreColumns:[];
    }

    public function getSeeds(){

        $s = [];
        $seeds = isset($this->seed) && $this->seed !== null? $this->seed:[];

        foreach($seeds AS $seed){
            $x = explode("_",$seed, 2);
            if($x[0] === "dbf"){
                $path = \Config::get('cp')['files'][$x[1]];
                
			}else if($x[0] === "config"){
                $path = null;
			}

            $s[] = [
                "type"=> $x[0],
                "id"=> $x[1],
                "path"=> $path
            ];
		}

        return $s;
    }

    public function getAttributeTypes(){
        if(isset($this->attributeTypes)){
            return $this->attributeTypes;  
		}else{
            return [];  
		}
	}

    public function isFromDbf(){
        $ans = false;

        foreach($this->getSeeds() AS $seed){
            if($seed["type"] === "dbf"){$ans = true;}
        }

        return $ans;
    }

    public function getIndexesAttribute(){
        return $this->indexes;
    }

}
