<?php namespace App\Core;

use Config, Schema;
use App\Ask\DatabaseType\PHPXbase\XBaseTable as DbfTable;

Trait ManageTableTrait
{

	 public function dropTable(){

		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	    \Schema::dropIfExists( $this->getTable() );
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		return $this;
	
	}

        public function emptyTable(){
		    static::truncate();
		    return $this;
	    }

    public function manager(){
        return \App\Dbf::where('name',"LIKE", $this->getTable())->first();
    }

    public function createTable(){
        
        if(Schema::hasTable($this->getTable())){
            $this->dropTable();
        }

		Schema::create($this->getTable(),function($table) {
				$table->increments('id');
                $table = \App\Helpers\Misc::setUpTableFromHeaders($this->getTable(), $table, $this->headers);
                $table->charset = 'utf8';
				$table->collation = 'utf8_unicode_ci';
			});	
	}

	public static function seedTable(){
		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		$model = new static;
    	
		\Eloquent::unguard();
		
    	$model->emptyTable();

        foreach($model->getSeeds() AS $seed){ // array[type,id,path]

			switch($seed['type']){
				
				case 'xml':
					foreach($model->xml()->all()->records AS $item){
						$item->save();
					}
					break;

				case 'config':
					$conf = Config::get('cp');

					foreach($conf[$seed['id']] AS $mdl){
						static::create($mdl);
					}
					break;

				case 'dbf':
					$model->dbf()
					->skipModel(true)
					->import($model->getTable())
					->all()
					//->reset()
					;

				default:
					break;
			}

		}
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		return $model;

	}	

	 public function getHeadersAttribute(){

		$fillable = $this->getFillable();
        $headers = $this->getAttributeTypes();
        $ignore = $this->getIgnoreColumns();

        if(isset($headers["_config"]) ){
        
            $path = Config::get('cp')["files"][$headers["_config"]];
            
            $table = new DbfTable($path);
            $table->open();
            $cols = $table->getColumns();

            foreach($cols AS $col){
                $con = $col->getContainer();
                $name = $con["name"];

                if(!in_array($name,$ignore) ){
			    	$headers[$name] = [
	                    "name" => $name,
	                    "type" => $con["type"],
	                    "length" => $con["length"],
	                    "nullable" => true
	                ];
            	}
		    }
            $table->close();
            unset($headers["_config"]);

           $headers["INDEX"] =[
            "name" => "INDEX",
            "type" => "Int",
            "length" => 15,
            "nullable" => false
           ];

		}

        if(isset($headers["timestamps"]) && $headers["timestamps"] === true){
            unset($headers['timestamps']);

            $headers["created_at"] = [
            "name" => "created_at",
            "type" => "TIMESTAMP",
            "length" => 19,
            "nullable"=>false
           ];
            $headers["updated_at"] = [
            "name" => "updated_at",
            "type" => "TIMESTAMP",
            "length" => 19,
            "nullable"=>false
            ];
		}

        foreach($fillable AS $att){

            if(!isset($headers[$att])){
		    	$headers[$att] = [
                    "name" => $att,
                    "type" => "String",
                    "length" => 96,
                    "nullable"=> true
                ];
			}
            
		}
        
	    return $headers;
	}

}
