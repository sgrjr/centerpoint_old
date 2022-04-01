<?php namespace App\Helpers;

use DB, Config, Schema;
use App\Helpers\StringHelper;
use App\Models\Dbf;
use stdclass;

use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseManager {

	public $files= [];
	public $commands = [];

	public function __construct($reset = false){
		$this->config = Config::get("cp");

		$this->results = [];
		
		//SHOULD GRAB FROM CONFIG FILE ONLY IF "tables" is not populated in database
		//then tables should be grabbed from database
		//manage touches to db tables
		$this->commands = $this->config["commands"];
		$this
			->setDB($reset)
			->setTables();
		//ini_set('max_execution_time', 1000000);
		//ini_set('memory_limit', '1.5G');

		$this->console = new ConsoleOutput();
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
	public function setDB($reset){

        if($reset){
        	static::dropDatabaseIfExists($this->config["dbname"]);
        }

        $db = static::createDBIfNotExists($this->config["dbname"]);

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
			$table = new $tc[0];
			$table->exists = $table->tableExists;
			$table->mysqlCount = 0; //find another solution for this data
			$tables[$table->getTable()] = $table;
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



public function execute(\Illuminate\Http\Request $request, $viewer){
			$this
				->setViewer($viewer)
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
					//Continue if table is to be seeded from a migration and created from a schema defined in the model
					$headers = $this->getHeaders($t->getTable());
					dd('line ' . 157);
					//$this->schema($t->getTable(), $headers);
					$this->addResult("imported fresh", $t->getTable(), false);
				}	
			}

		}else{

			//immediately return with error if table already exists.
			if(Schema::hasTable($opt->name)){
				$this->addResult("Table " . $opt->name . " not created as it already exists in database.");
				return $this;
			}

			$table = $this->getTableByName($opt->name);
			
			if(!$table->isFromDbf() || is_array($table->getSeeds()) ){

				$table->createTable();
	
				$this->addResult("Table " . $opt->name . " was created.", $table->getTable(), false);
				return $this;
			}else if($table !== null){	
				dd('line ' . 177);
				//$headers = $this->getHeaders($table->getTable());
				//$this->schema($table->getTable(), $headers);
				//$this->addResult("Table " . $opt->name . " was created.", $table->getTable(), false);
			}

		}

		 return $this;
	}

	public function dropAllTables(){
		$opt = new stdclass;
        $opt->name = "ALL";
        $this->dropTable($opt);

	}
	public function dropTable($opt){

		if($opt->name === "ALL"){
			foreach($this->tables AS $t){
				if($t->source !== "SEED"){
					if(Schema::hasTable($t->getTable())){
						$t->dropTable();
						$this->addResult("Table " . $t->name . " was deleted.", $t->getTable(), false);
					}

				}		
			}
			
			
		}else{
			if(Schema::hasTable($opt->name)){
				$table = $this->getTableByName( $opt->name);
				\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
				$table->dropTable();
				\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
				$this->addResult("Table " . $opt->name . " was deleted.", $opt->name, false);
			}
		}
		
		return $this;
	}
	
	public function truncateTable($opt){
		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$table = $this->getTableByName($opt->name);

		if($opt->name !== "dbfs"){	
			$table->truncate();	
			$this->addResult("Table " . $opt->name . " was truncated.", $table->getTable(), false);
		}else if($table === null){
			$this->addResult("FAILED: dbfs Table not Truncated with: " . $opt->name . ". Dbf of entry with same name could not be found.");
		}else if($opt->name === "dbfs"){
			Dbf::truncate();
			$this->addResult("Table Manager ('dbfs table') was truncated.", false, false);
		}else{
			$this->addResult("Nothing Happened.");
		}

		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		return $this;
	}

	private function seedATable($t){
		$this->console->writeln($t->getTable() . " started...");
		$start = microtime(true);
		$t->seedTable();
		$this->console->writeLn($t->getTable() ." was seeded.");
		$time_elapsed_secs = microtime(true) - $start;
		$this->console->writeln(" => " . round($time_elapsed_secs/60,2) . " min");
	}

	public function seedTable($opt){

		if($opt->name === "ALL"){
		
			foreach($this->tables AS $t){

				if($opt->overwrite === true || $opt->overwrite === 'true'){
					$this->seedATable($t);
				}else if($t->first() === null){
					$this->seedATable($t);
				}else{
					$this->console->writeln("Table '" . $t->getTable() . "' not seeded.");
				}

			}
			return $this;
		}else{
			$tables = explode(',', $opt->name);

			foreach($tables AS $table){
				$start = microtime(true);
				$table = $this->getTableByName(trim($table));
				
				$result = false;

				if($opt->overwrite === true || $opt->overwrite === 'true'){
					$this->seedATable($table);
				}else if($table->first() === null){
					$this->seedATable($table);
				}else{
					$this->console->writeln("Database table ".$table->getTable()." not seeded because it already contains entries.");
				}

				$time_elapsed_secs = microtime(true) - $start;
				$this->console->writeln($opt->name." " . round($time_elapsed_secs/60,3) . " min");
			}
		}

		return $this;
	}

	public function rebuildAllTables($db_name, $shouldSeed = true){

		\Artisan::call('migrate:fresh');
		\Artisan::call('passport:client --personal');
		if($shouldSeed) \Artisan::call('db:seed');
		return $this;
	}

	public function rebuildAllDbfTables($db_name, $shouldSeed = true){

		$start_time = microtime(true); 

		foreach($this->tables AS $t){
			$opt = new \stdclass;
			$opt->name = $t->getTable();
			$opt->seed = $shouldSeed;
			$this->rebuildTable($opt, false);
		}

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
			if($opt->seed && \Schema::hasTable($opt->name)){
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
						"name"=> $r->getTable(),
						"source"=> $r->source,
						"memo"=> $r->getMemo(),
						"model"=> get_class($r),
					];

					$dbf = \App\Models\Dbf::make($array);
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

	public static function rebuild($db_name, $shouldSeed = false, $table = false){
		$dm = new static();

        if($table){
        	$tables = explode(',', $table);

        	foreach($tables AS $table){
        		$opt = new stdclass;
        		$opt->name = trim($table);
        		$opt->seed = $shouldSeed;
        		$opt->overwrite = true;
	            $dm->dropTable($opt);
        	}

        	foreach($tables AS $table){
        		$dm = new static();
	            $opt = new \stdclass;
	            $opt->name = $table;
	            $opt->seed = $shouldSeed;
	            $opt->overwrite = true;
	            $dm->rebuildTable($opt);
        	}

        }else{
        	$dm = new static(true);
            $dm->rebuildAllTables($db_name, $shouldSeed);
        }
	}

	public static function dropDatabaseIfExists($name){
		config(["database.connections.mysql.database" => null]);
        DB::reconnect('mysql');
        $query = "DROP DATABASE IF EXISTS $name;";
        DB::statement($query);
	}

	private static function createDatabase($name){
		$charset = config("database.connections.mysql.charset",'utf8mb4');
        $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');

        config(["database.connections.mysql.database" => null]);

        DB::reconnect('mysql');

        $query = "CREATE DATABASE IF NOT EXISTS $name CHARACTER SET $charset COLLATE $collation;";

        DB::statement($query);
        DB::statement("USE $name;");

        config(["database.connections.mysql.database" => $name]);
	}

	public function createDBIfNotExists($db_name){
		
		if(!static::databaseExists($db_name)){
			static::createDatabase($db_name);
		}
		return true;
	}

	private static function databaseExists($db_name){
		$query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $db = DB::select($query, [$db_name]);
        if (empty($db)) {
            //'No db exist of that name!';
            return false;
        } else {
            //'db already exists!';
            return true;
        }
	}

	public function foreignKeysUp(){
		foreach($this->tables AS $model){

			if($model->isFromDbf() && Schema::hasTable($model->getTable()) !== false){
		        $model->addForeignKeys();
			}	
		}
	}

	public function foreignKeysDown(){
		foreach($this->tables AS $model){

			try{
				$model->dropForeignKeys();
			}

			catch(\Exception $e){
				//keep going
				dd($e);
			}
		}
	}

}

//SAVED QUERIES

// SSELECT `id`,`date`,`key`,`transno`, COUNT(*) c FROM `ancienthead` GROUP BY `transno` HAVING c > 1;