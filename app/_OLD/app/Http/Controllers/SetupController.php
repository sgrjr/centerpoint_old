<?php namespace App\Http\Controllers;

use Artisan, Config, DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\MakeTable;
use App\User;
use App\Helpers\SetupTests;
class SetupController extends BaseController
{

    public function index(Request $request)
    {		

		$db = DB::getDatabaseName();

		try {
				$tables = \DB::select("select table_name as 'name', SUM(TABLE_ROWS) as 'rows' FROM INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA='".$db."' group by TABLE_NAME;");
		}


		catch(\Illuminate\Database\QueryException $e){
			Artisan::call('db:create');
			config(["database.connections.mysql.database" => config("database.connections.mysql.database")]);
			DB::reconnect('mysql');

			Artisan::call('migrate');

			$tables = \DB::select("select table_name as 'name', SUM(TABLE_ROWS) as 'rows' FROM INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA='".$db."' group by TABLE_NAME;");
		}

		$updateExists = false;
		$update = null;
		    $path = base_path() . DIRECTORY_SEPARATOR . "dbf_changes.json";
                    if(file_exists($path)){
                      $updateExists = true;
                      $update = file_get_contents($path);
                    }

        $errors = \App\Helpers\Misc::getErrors();

        $tests = [];
        $st = new SetupTests();
        $tests = $st->all();

        return view('admin.setup', [
            "tables"=> $tables,
            "error" => $errors,
            "updateExists" => $updateExists,
            "update"=> $update,
            "tests" => $tests
        ]);
		   
	}
	
    public function migrate(Request $request)
    {   
		ini_set('max_execution_time', 1000000);
		ini_set('memory_limit', '5.5G');
        $exitCode = Artisan::call('migrate', []);
		$request->session()->flash('message', $exitCode);

        return redirect("/setup");    
    }
	
	public function optimize(Request $request)
    {   
        $exitCode = Artisan::call('optimize', []);
        $request->session()->flash('message', $exitCode);
        return redirect("/setup");    
    }
	
	public function rollback(Request $request)
	{   
		$exitCode = Artisan::call('migrate:rollback');
        $request->session()->flash('message', $exitCode);
        return redirect("/setup");   
	}
	
	public function seed(Request $request)
	{   
		ini_set('max_execution_time', 1000000);
		ini_set('memory_limit', '1.5G');
		$exitCode = Artisan::call('db:seed --class=UsersTableSeeder');
		$exitCode = Artisan::call('db:seed --class=RolesTableSeeder');
		$exitCode .= Artisan::call('db:seed --class=Role_userTableSeeder');
$exitCode .= Artisan::call('db:seed --class=InventoriesTableSeeder');
$exitCode .= Artisan::call('db:seed --class=VendorsTableSeeder');
$exitCode .= Artisan::call('db:seed --class=Standing_ordersTableSeeder');

        $request->session()->flash('message', true);
        return redirect("/setup");   
	}

	public function reset(Request $request){

		Artisan::call('migrate:reset', ['--force' => true]);
		$request->session()->flash('message', "Database reset to no seeded tables!");
        $path = base_path() . DIRECTORY_SEPARATOR . "dbf_changes.json";
        if(file_exists($path)){
          unlink($path);
        }
        return redirect("/setup");   

	}

	public function fresh(Request $request){

		
        ini_set('max_execution_time', 1000000);
		ini_set('memory_limit', '1.5G');
        \Artisan::call('migrate:fresh',['--seed'=>true]);

		$request->session()->flash('message', "Database reset and seeded!");
        return redirect("/setup");   
       
    
	}

	public function terminal(Request $request)
    {
		$command = $request->input('command');
		$opt = json_decode($request->input('options'));
		$response = \App\Helpers\TerminalCommands::exec($command, $opt);
		$request->session()->flash('message', json_encode($response));
        return redirect("/setup");   
	}

	public function pull(Request $request)
    {
    	$opt = new \stdclass;
    	$opt->message = "changes from cp server";

		$response = \App\Helpers\TerminalCommands::exec("GIT_ALL_COMMANDS", $opt);
		$request->session()->flash('message', json_encode($response));

        return redirect("/setup");   
	}

	private function checkIfDbExists(){
		$query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $db = DB::select($query, Config::get('cp')['dbname']);
        return empty($db)? false:true;
	}
}
