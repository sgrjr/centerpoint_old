<?php namespace App\Traits;

use Config, Schema;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\ProgressBar;

Trait ManageTableTrait
{

	 public function dropTable(){
		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	    \Schema::dropIfExists( $this->getTable() );
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		return $this;
	}

    public function emptyTable(){
    	if( \Schema::hasTable($this->getTable() ) ){
    		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	    	static::truncate();
			\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    	}
    	
	    return $this;
    }

    public function manager(){
        return \App\Models\Dbf::where('name',"LIKE", $this->getTable())->first();
    }

    public function createTable(){

        if(Schema::hasTable($this->getTable())){
            $this->dropTable();
        }

		Schema::create($this->getTable(),function($table) {
			$table->increments('id');
            $table = \App\Helpers\Misc::setUpTableFromHeaders($table, $this->headers, $this);
            $table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';			
		});		

		return $this;
	}

	public function addForeignKeys(){
		$keys = $this->getForeignKeys();
		Schema::disableForeignKeyConstraints();
		Schema::table($this->getTable(),function($table) use($keys) {
			foreach($keys AS $fk){
            	$table->foreign($fk[0])->references($fk[1])->on($fk[2]);
        	}
		});	
		Schema::enableForeignKeyConstraints();
		return $this;
	}



    public function dropForeignKeys(){
       $keys = $this->getForeignKeys();

		Schema::table($this->getTable(),function($table) use($keys) {
			foreach($keys AS $fk){
				$k = $fk[0];
            	$table->dropForeign([$k]);
        	}
		});	
		return $this;
    }

    public function getForeignKeys(){
        return ($this->foreignKeys)? $this->foreignKeys:[];
    }

	public function seedTable(){
		
    	$this->emptyTable();

        foreach($this->getSeeds() AS $seed){ // array[type,id,path]

			switch($seed['type']){
				
				case 'xml':
					foreach($this->xml()->all()->records AS $item){
						$item->save();
					}
					break;

				case 'config':
					$conf = Config::get('cp');

					foreach($conf[$seed['id']] AS $mdl){
						$model = static::create($mdl);
					}
					break;

				case 'dbf':
					$this->seedFromDBF();
					$this->doAfterSeed();
					break;
				default:
					break;
			}

		}

		return $this;

	}

	public function seedFromDBF(){
            ini_set('memory_limit','512M');
            $output = new ConsoleOutput();
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $file = $this->xTable();
            $file->open();
            
            	$bag = [];
            	$count = $file->count();
            	$output->write("<fg=green>STARTING TO IMPORT: " . $count . " RECORDS...");

            	$progressBar = new ProgressBar($output, $count);
				$progressBar->setBarCharacter('<fg=green>⚬</>');
				$progressBar->setEmptyBarCharacter("<fg=red>⚬</>");
				$progressBar->setProgressCharacter("<fg=green>➤</>");
				$progressBar->setFormat("<fg=white;bg=cyan> %status:-45s%</>\n%current%/%max% [%bar%] %percent:3s%% %estimated:-20s% %memory:20s%", $progressBar->getFormatDefinition('debug')); // the new format

            	$progressBar->start();

	            while ($record=$file->nextRecord() ) {
	                $rd = $record->getData($this->getIgnoreColumns());
	                $bag[] = $rd;
	                $progressBar->setMessage($this->getTable() . " [" . $rd["INDEX"] ."]", 'status'); // set the `status` value
	                $progressBar->advance();
	                if(count($bag) > 400){
	                    $this->insert($bag);
	                    $bag = [];
	                }
	            }

	            $this->insert($bag);
	            $bag = [];
	            $progressBar->finish();

            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $file->close();

            unset($dbf);
            unset($bag);
            unset($file);
            unset($rd);

            return $this;

	}	

	 public function getHeadersAttribute(){
		$fillable = $this->getFillable();
        $headers = $this->getAttributeTypes();
        $ignore = $this->getIgnoreColumns();

        if(isset($headers["_config"]) ){
            
            $table = $this->xTable();
            $table->open();
            $cols = $table->getColumns();
            $table->close();

            foreach($cols AS $col){
                $con = $col->getContainer();
                $name = $con["name"];

                if($name !== null && !in_array($name,$ignore) ){
			    	$headers[$name] = $con;
            	}
		    }

           unset($headers["_config"]);

           $headers["INDEX"] =[
            "name" => "INDEX",
            "type" => "Int",
            "mysql_type" => "Int",
            "length" => 15,
            "nullable" => false,
            "decimal_count" => 0
           ];

           $headers["DELETED"] =[
            "name" => "DELETED",
            "type" => "Boolean",
            "mysql_type" => "Boolean",
            "length" => 1,
            "nullable" => false,
            "decimal_count" => 0
           ];

		}

        if(isset($headers["timestamps"]) && $headers["timestamps"] === true){
            unset($headers['timestamps']);

            $headers["created_at"] = [
            "name" => "created_at",
            "type" => "TIMESTAMP",
            "mysql_type" => "TIMESTAMP",
            "length" => 19,
            "nullable"=>false,
            "decimal_count" => 0
           ];
            $headers["updated_at"] = [
            "name" => "updated_at",
            "type" => "TIMESTAMP",
            "mysql_type" => "TIMESTAMP",
            "length" => 19,
            "nullable"=>false,
            "decimal_count" => 0
            ];
		}

        foreach($fillable AS $att){

            if(!isset($headers[$att])){
		    	$headers[$att] = [
                    "name" => $att,
                    "type" => "String",
                    "mysql_type" => "String",
                    "length" => 96,
                    "nullable"=> true,
            		"decimal_count" => 0
                ];
			}
            
		}
        
	    return $headers;
	}

	public function doAfterSeed(){
		//
	}

}
