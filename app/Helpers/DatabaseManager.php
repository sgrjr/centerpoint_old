<?php namespace App\Helpers;

use DB, Config, Schema;
use App\Helpers\StringHelper;
use App\Dbf;

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
		//ini_set('max_execution_time', 1000000);
		//ini_set('memory_limit', '1.5G');
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
			$table = new $tc[0];
			$table->exists = $table->tableExists;
			$table->mysqlCount = 0; //find another solution for this data
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
					$headers = $this->getHeaders($t->getTable());
					$this->schema($t->getTable(), $headers);
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
				$headers = $this->getHeaders($table->getTable());
				$this->schema($table->getTable(), $headers);
				$this->addResult("Table " . $opt->name . " was created.", $table->getTable(), false);
			}

		}

		 return $this;
	}

	public function dropTable($opt){

		if($opt->name === "ALL"){
			
			foreach($this->tables AS $t){
				if($t->source !== "SEED"){
					$t->dropTable;
					$this->addResult("Table " . $opt->name . " was deleted.", $t->getTable(), false);
				}		
			}
			
			
		}else{
			$table = $this->getTableByName( $opt->name);
			$table->dropTable();
			$this->addResult("Table " . $opt->name . " was deleted.", $opt->name, false);
		}
		
		return $this;
	}
	
	public function truncateTable($opt){

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

		return $this;
	}
	
	public function seedTable($opt){
		
		if($opt->name === "ALL"){
		
			foreach($this->tables AS $t){
				$t->seedTable();
				$this->addResult($t->getTable() ." was seeded.", false, false);
			}
			return $this;
		}
		$table = $this->getTableByName($opt->name);
		
		$result = $table->seedTable();

		if(!$result){
			$this->addResult("ERROR: Database is missing table named: " . $table->getTable());	
		}else{
			$this->addResult($table->getTable() ." was seeded.", false, false);
		}

		return $this;
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
						"name"=> $r->getTable(),
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