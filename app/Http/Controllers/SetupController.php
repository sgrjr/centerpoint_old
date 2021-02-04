<?php namespace App\Http\Controllers;

use Artisan, Config, DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\MakeTable;
use App\User;

class SetupController extends BaseController
{

    public function index(Request $request)
    {		

    	//dd(\App\User::where('KEY',"0484900000044")->first()->vendor->carts);

		if(\Schema::hasTable('users') && \Schema::hasTable('roles') && \Schema::hasTable('role_user')){
			
			try {
				$user = User::find(1);
			
				if( $user !== null && $user->can("ADMIN_APP") ){
					return redirect("/admin/db"); 
				}
			}

			catch(\Throwable $e){
				$user = false;
			}
		}

		$ts = \DB::select('SHOW TABLES');
		$tables = [];
			
		//programtically getting db name from env; not hard written
		$tables_in_dbname = "Tables_in_" . DB::getDatabaseName();
			foreach($ts AS $t){
				$tables[] = $t->$tables_in_dbname;
			}

			if(\Schema::hasTable('users') ){
				$users = \App\User::all();
			}else{
				$users = [];
			}

        return view('admin.setup', [
            "tables"=> $tables,

            "error" => \App\Helpers\Misc::getErrors(),
            "users" => $users
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
        $request->session()->flash('message', true);
        return redirect("/setup");   
	}

	public function reset(Request $request){

		Artisan::call('migrate:reset', ['--force' => true]);
		$request->session()->flash('message', "Database reset to no seeded tables!");
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

        return redirect("/admin/db");   
	}

	private function checkIfDbExists(){
		$query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $db = DB::select($query, Config::get('cp')['dbname']);
        return empty($db)? false:true;
	}
}