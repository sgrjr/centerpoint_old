<?php namespace App;

use DB, Config, Schema;
use App\Helpers\StringHelper;
use App\Dbf;
use App\CallbackImport;

class DatabaseManager {

	public $files= [];
	public $commands = [];

	public function __construct(){
		$this->config = Config::get("cp");

		$this->results = [];
		
		//SHOULD GRAB FROM CONFIG FILE ONLY IF "tables" is not populated in database
		//then tables should be grabbed from database
		//mange touches to db tables
		$this->commands = $this->config["commands"];
		$this
			->setDB()
			->setTables();
		ini_set('max_execution_time', 1000000);
		ini_set('memory_limit', '1.5G');
	}

	private function addResult($message, $table = false, $error = true){
		$result = new \stdclass;
		$result->error = $error;
		$result->message = $message;
		$result->table = $table;
		array_push($this->results, $result);
		return $this;
	}

        /*
        check if db exists
        Booleon will be set; TRUE/FALSE
        */
	public function setDB(){

        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $db = DB::select($query, [$this->config["dbname"]]);
		
		if(isset($db[0])){
			$this->dbStatus = true;
		}else{
			$this->dbStatus = false;
		}

		return $this;
		
	}

	public function setTables(){
		$tables_conf = $this->config["tables"];
		$tables = [];

		foreach($tables_conf AS $key=>$tc){
			$table = new $tc["class"];
			$table->exists = $table->tableExists;
			if($table->exists){
				$table->mysqlCount = $table->count();
			}else{
				$table->mysqlCount = 0;
			}
			
			$tables[$key] = $table;
		}

		$this->tables = $tables;

		return $this;
		
	}

	private function setViewer($viewer){
		$this->viewer = $viewer;
		return $this;	
	}

	private function saveCommand(){

		if(Schema::hasTable('commands')){
			$newCommand = new Command(["command"=>$this->command, "options"=> json_encode($this->commandOptions), "user_id"=>$this->viewer->id]);
			$newCommand->save();
		}

		return $this;	
	}

	private function doAction(){
		$command = $this->command;
		$this->$command( $this->commandOptions );
		return $this;
	}

	private function flashMessage($request){

		$messages = "<ul class='alert alert-info'>";
		foreach($this->results AS $r){
			$messages .= "<li class='error";
			$messages .=  $r->error."'>";
			$messages .= $r->message;
			$messages .= " (";
			$messages .= $r->error? "FAIL":"SUCCESS";
			$messages .= ")</li>"; 
		}

		$messages .= "</ul>";

		$request->session()->flash('message', $messages); 

		return $this;
	}

	private function loadManager(){

			if(!Schema::hasTable('dbfs') ){
				$opt = new \stdclass;
				$opt->name = "dbfs";
				$this->createTable($opt);
			}

			if(\App\Dbf::mysql()->count() < 1 ){
				$rows = $this->getTables();
				$this->importList("dbfs", $rows);
			}

			return $this;
	}

public function execute(\Illuminate\Http\Request $request, $viewer){
			$this
				->setViewer($viewer)
				->loadManager()
				->validateCommand($request)
				->doAction()
				->completed()
				->saveCommand()
				->flashMessage($request);

			return $this;
	}
	
	public function validateCommand(\Illuminate\Http\Request $request){

		$command = $request->input('command');
		$this->commandOptions = json_decode($request->input('options'));
		$this->command = StringHelper::camelCase($command); 		

		if(in_array($command, $this->commands)){
	   	 	return $this;
	   	 }else{
	   	 	dd('error', 'Check your spelling Mr. Developer. '.$this->command.' has not be registered. ' . json_encode($this->commands));
	   	 }

	}

	public function createTable($opt){
		$result = new \stdclass;
		
		if($opt->name === "ALL"){
			foreach($this->tables AS $t){
				if($t->isFromDbf() && Schema::hasTable($t->getTable()) === false){	
					//Contintue if table is to be seeded from a migration and created from a schema defined in the model
					$headers = $this->getHeaders($t->tableSafeName);
					$this->schema($t->tableSafeName, $headers);
					$this->addResult("imported fresh", $t->tableSafeName, false);
				}	
			}

		}else{

			//immediately return with error if table already exists.
			if(Schema::hasTable($opt->name)){
				$this->addResult("Table " . $opt->name . " not created as it already exists in database.");
				return $this;
			}

			$table = $this->getTableByName($opt->name);
			
			if(!$table->isFromDbf() || is_array($table->getSeed()) ){
				$table->createTable();
				$this->addResult("Table " . $opt->name . " was created.", $table->tableSafeName, false);
				return $this;
			}else if($table !== null){	
				$headers = $this->getHeaders($table->tableSafeName);
				$this->schema($table->tableSafeName, $headers);
				$this->addResult("Table " . $opt->name . " was created.", $table->tableSafeName, false);
			}

		}

		 return $this;
	}

	public function dropTable($opt){
		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		if($opt->name === "ALL"){
			
			foreach($this->tables AS $t){
				if($t->source !== "SEED"){
					Schema::dropIfExists($t->tableSafeName);
					$this->addResult("Table " . $opt->name . " was deleted.", $t->tableSafeName, false);
				}		
			}
			
			
		}else{
			Schema::dropIfExists($opt->name);
			$this->addResult("Table " . $opt->name . " was deleted.", $opt->name, false);
		}
		
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		return $this;
	}
	
	public function truncateTable($opt){

		$table = $this->getTableByName($opt->name);

		if($opt->name !== "dbfs"){	
			$table->truncate();	
			$this->addResult("Table " . $opt->name . " was truncated.", $table->tableSafeName, false);
		}else if($table === null){
			$this->addResult("FAILED: dbfs Table not Truncated with: " . $opt->name . ". Dbf of entry with same name could not be found.");
		}else if($opt->name === "dbfs"){
			Dbf::truncate();
			$this->addResult("Table Manager ('dbfs table') was truncated.", false, false);
		}else{
			$this->addResult("Nothing Happened.");
		}

		return $this;
	}
	
	
	
	public function seedTable($opt){
		
		if($opt->name === "ALL"){
		
			foreach($this->tables AS $t){
				if($t->isFromDbf()){
					$this->seedATable($t->tableSafeName);
					$this->addResult($t->tableSafeName ." was seeded.", false, false);
				}
			}
			return $this;
		}
		
		return $this->seedATable($opt->name);

	}

	public function rebuildAllDbfTables(){
		
		$start_time = microtime(true); 

		\DB::raw("SET autocommit=0;SET unique_checks=0;SET foreign_key_checks=0; SET innodb_autoinc_lock_mode = 2;");

			foreach($this->tables AS $t){
				if($t->isFromDbf()){
					$opt = new \stdclass;
					$opt->name = $t->getTable();
					$this->rebuildTable($opt, false);
				}
			}

		\DB::raw("SET unique_checks=1;SET foreign_key_checks=1; SET innodb_autoinc_lock_mode = 2;");
		\DB::commit();

			$length = \Carbon\Carbon::createFromTimeStamp($start_time)->diffInSeconds()/60;

			$this->addResult("Tables were was seeded ( " . $length ." minutes)", false, false);


			return $this;


	}

	public function rebuildTable($opt, $ini = true){
			
		if(\Schema::hasTable($opt->name)){
			$this->dropTable($opt);
			$this->addResult($opt->name ." was dropped.", false, false);
		}
		
		if(! \Schema::hasTable($opt->name)){
			$this->createTable($opt);
			$this->addResult($opt->name ." was rebuilt.", false, false);

			if(\Schema::hasTable($opt->name)){
				$this->seedTable($opt);
				$this->addResult($opt->name ." was seeded.", false, false);
			}
		}

		return $this; 
	}
	
	public function importList($tablename, $rows){

		\Eloquent::unguard();

        //disable foreign key check for this connection before running seeders
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if(is_object($rows)){
        	$rows = $rows->toArray();
        }

		// insert rows
		$rows = array_chunk($rows, 500);

		\DB::transaction(function () use ($tablename, $rows){
			foreach($rows AS $ro){
				foreach($ro AS $r){

					$array = [
						"name"=> $r->tableSafeName,
						"source"=> $r->source,
						"memo"=> $r->getMemo(),
						"model"=> get_class($r),
					];

					$dbf = \App\Dbf::make($array);
					$dbf->save();
				}
			}
		});	   

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		
		return true;
		
	}
	
	public function getTableByName($name){

		if(is_array($name)){
			
			$tables = [];
		
			foreach($name AS $t){
				if( array_key_exists($this->tables, $t) ){
					$tables[$t] = $this->tables[$t];
				}
			}
			return $tables;

		}else{		
			return $this->tables[$name];
		}

	}

	public function getTables(){
		return $this->tables;
	}

	public function schema($name, $headers){

		Schema::create($name,function($table) use ($name, $headers)
			{
				$table->increments('id');

				$table->integer("INDEX", false)->nullable();	

				if(is_string($headers) || isset($headers->error)){
					dd($name,$headers);
				}

				$overRideToString = ["ALLSALES","ONHAND","ONORDER","TRANSNO"];
				$overRideToNumber = ["PUBDATE"];

				foreach($headers AS $h){
					if(in_array($h["name"], $overRideToString)){
						$table->string($h["name"])->nullable();
					}else if(in_array($h["name"], $overRideToNumber)){
						$table->integer($h["name"])->nullable();
					}else{

					switch($h["type"]){
						case 'character':
						case 'C':
						case 'G':

							$table
								->string($h["name"], $h["length"])
								->char('utf8')
								->collate('utf8_unicode_ci')
								->nullable();
							break;
						case 'number':
						case 'numeric':
						case 'Number':	
						case 'N': //Numeric	
								$table->decimal($h["name"],13)
								->char('utf8')
								->collate('utf8_unicode_ci')
								->nullable();	
								break;

						case 'I':		//Integer	
								$table->integer($h["name"], false)
								->char('utf8')
								->collate('utf8_unicode_ci')
								->nullable();		
							break;
						case 'memo':
						case 'M':
							$table
								->binary($h["name"])
								->char('utf8')
								->collate('utf8_unicode_ci')
								->nullable();
							break;
						default:
							$table
							->string(strtolower($h["name"]), 255)
							->char('utf8')
							->collate('utf8_unicode_ci')
							->nullable();
					}
				}
			}
			$callback = $name."Schema";

			if(method_exists($this,$callback)){
				$table = call_user_func([$this, $callback], $table);	
			}

			$table->timestamps();

			$table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';
			});
		
	}

 		public function getHeaders($name){
	 		$table = $this->getTableByName($name);

	 		$headers = [];
			foreach ($table->dbf()->getColumns() as $i=>$c) {
				$h = [];
		    	$h["name"] = $c->getName();
		    	$h["type"] = $c->getType();
		    	$h["length"] = $c->getLength();

		    	$headers[] = $h;
		    }
	    return $headers;

    }
	
	public function inventorySchema($table){
		$table->string("allsales")->nullable()->change();
		return $table;
	}
	
	public function vendorSchema($table){
		//$table->index('key'); //find out why there are duplicate keys so i can change this to unique('KEY'). right now is getting error on insert due to duplicates.
		return $table;
	}
	
	public function passwordSchema($table){
		//$table->foreign('key')->references('key')->on('vendor');
		//find out why there are keys in password that are not in vendor so i can uncoment this.
		return $table;
	}

	public function passfileSchema($table){
		//$table->decimal('discount', 5, 2);
		//$table->decimal('listprice', 5, 2);
		//$table->decimal('saleprice', 5, 2);
		return $table;
	}
	public function standingordersSchema($table){
		//$table->foreign('key')->references('key')->on('vendor');
		//find out why there are keys in password that are not in vendor so i can uncoment this.
		return $table;
	}

	/* ORDERS SCHEMA START */

	public function ancientheadSchema($table){ $table->unique('transno'); return $table;	}
	public function ancientdetailSchema($table){$table->foreign('transno')->references('transno')->on('ancienthead'); return $table;	}
	
	public function allheadSchema($table){ $table->unique('transno'); return $table;	}
	public function alldetailSchema($table){$table->foreign('transno')->references('transno')->on('allhead'); return $table;	}
	
	public function broheadSchema($table){$table->unique('transno'); return $table;}
	public function brodetailSchema($table){$table->foreign('transno')->references('transno')->on('brohead'); return $table;}
	
	public function backheadSchema($table){ 
		//$table->unique('transno'); 
		return $table;
	}
	public function backdetailSchema($table){$table->foreign('transno')->references('transno')->on('backhead'); return $table;	}
	
	public function webheadSchema($table){ $table->unique('transno'); return $table;	}
	public function webdetailSchema($table){$table->foreign('transno')->references('transno')->on('webhead'); return $table;	}
	
	/* ORDERS SCHEMA END */

	private function seedATable($tableName){

		if(!Schema::hasTable($tableName)){
			$this->addResult("ERROR: Database is missing table named: " . $tableName);	
			return $this;
		}

		$table = $this->getTableByName($tableName);

		if($table->source === "XML"){
			$table->truncate();
			$rows = $table->xml()->all();

			foreach($rows->records AS $item){
				$item->save();
			}
		}else if($table->source === "SEED"){

			switch($table->tableSafeName){
				case 'orders':
				case 'order_items';
					$start_time = microtime(true); 
					$tables = $this->getTableByName(['order_items, orders']);
					$counter = $table->dbf()->seedOrders(); //expected response is the total number of rows imported
					$length = \Carbon\Carbon::createFromTimeStamp($start_time)->diffInSeconds();

					$this->addResult(
						"( ". $length . ") ". 
						$counter[0][0] . " rows were added to Table: ".$counter[0][1]." and .".
						$counter[1][0] . " rows were added to Table: ".$counter[1][1]." and ."
						, $table->tableSafeName, false);
					break;
				default:
					$table->truncate();

			}
		}else{
			$start_time = microtime(true);

			$records = $table::ask()
                ->skipModel(true)
                ->setPage(1)
                ->setPerPage(9999999)
                ->orderBy("INDEX","DESC")
                ->lists($table::getIndexes())
                ->import($table->tableSafeName)
                ->all()
				;

			$counter = $records->paginator->total; //expected response is the total number of rows imported
			$length = \Carbon\Carbon::createFromTimeStamp($start_time)->diffInSeconds();

			$this->addResult("( ". $length . ") ". $counter . " rows were added to Table: ".$table->tableSafeName." from DBF.", $table->tableSafeName, false);
		}

		return $this;
	}

	public function dbf($dbf_name){
		return $this->getTableByName($dbf_name);
	}

	public function completed(){

		if(Schema::hasTable('dbfs')){

		foreach($this->results AS $r){
			if(!$r->error && $r->table !== false){

				
					$manager = Dbf::where("name", $r->table)->first();

					if($manager === null){
						$manager = new Dbf();
					}
					$manager->updated_at = \Carbon\Carbon::now()->toDateTimeString();
					$manager->save();
				
			}			
		}

		}
		return $this;
	}

}

//SAVED QUERIES

// SSELECT `id`,`date`,`key`,`transno`, COUNT(*) c FROM `ancienthead` GROUP BY `transno` HAVING c > 1;