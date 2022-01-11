<?php namespace App\Traits;

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
        return \App\Models\Dbf::where('name',"LIKE", $this->getTable())->first();
    }

    public function createTable(){
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if(Schema::hasTable($this->getTable())){
            $this->dropTable();
        }

		Schema::create($this->getTable(),function($table) {
				$table->increments('id');
                $table = \App\Helpers\Misc::setUpTableFromHeaders($table, $this->headers);
                $table->charset = 'utf8';
				$table->collation = 'utf8_unicode_ci';

				foreach($this->indexes as $index){
					$table->index($index);
				}

		          switch($this->getTable()){

		            case "alldetails":
		              $table->foreign('TRANSNO')->references('TRANSNO')->on('allheads')->onUpdate('cascade')->onDelete('cascade');
		              $table->foreign('PROD_NO')->references('ISBN')->on('inventories')->onUpdate('cascade')->onDelete('cascade');
		              break;
		            case "ancientdetails":
		              $table->foreign('TRANSNO')->references('TRANSNO')->on('ancientheads')->onUpdate('cascade')->onDelete('cascade');
		              $table->foreign('PROD_NO')->references('ISBN')->on('inventories')->onUpdate('cascade')->onDelete('cascade');
		              break;
		            case "backdetails":
		              $table->foreign('TRANSNO')->references('TRANSNO')->on('backheads')->onUpdate('cascade')->onDelete('cascade');
		              $table->foreign('PROD_NO')->references('ISBN')->on('inventories')->onUpdate('cascade')->onDelete('cascade');
		              break;
		            case "brodetails":
		              $table->foreign('TRANSNO')->references('TRANSNO')->on('broheads')->onUpdate('cascade')->onDelete('cascade');
		              $table->foreign('PROD_NO')->references('ISBN')->on('inventories')->onUpdate('cascade')->onDelete('cascade');
		              break;
		            case "webdetails":
		              $table->foreign('REMOTEADDR')->references('REMOTEADDR')->on('webheads')->onUpdate('cascade')->onDelete('cascade');
		              $table->foreign('PROD_NO')->references('ISBN')->on('inventories')->onUpdate('cascade')->onDelete('cascade');
		              break;
		            case "booktexts":
		              $table->foreign('KEY')->references('ISBN')->on('inventories')->onUpdate('cascade')->onDelete('cascade');
		              break;
		            case "role_user":
		              $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
		              $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
		              break;
		            case "standing_orders":
		              $table->foreign('KEY')->references('KEY')->on('vendors')->onUpdate('cascade')->onDelete('cascade');
		              break;
		            case "dbfs":
		              $table->unique('name');
		              break;
		          }

			});	
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
					$resp = $model->dbf()
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
