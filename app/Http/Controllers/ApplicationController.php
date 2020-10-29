<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth, Session;
use App\Helpers\DatabaseManager;
use App\Dbf;
use App\Command;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$response = [];	
        $env = file_get_contents(base_path() . "/.env"); 
        $error = \App\Helpers\Misc::getErrors();	

        return view('application', ["response"=>$response,"envi"=>$env,"error"=>$error]);
    }
	
	public function command(Request $request)
    {
<<<<<<< HEAD
    $viewer = new \App\Helpers\Viewer();
=======
    $viewer = new \App\Viewer();
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

    if($viewer->can("ADMIN_APP")){

		$command = $request->input('command');
		$opt = json_decode($request->input('options'));
		
        if($opt === null){
            $opt = new \stdclass;
            $opt->message = "default commit message";
        }

		$response = \App\Helpers\TerminalCommands::exec($command, $opt);
        
        $env = file_get_contents(base_path() . "/.env");
        $error = file_get_contents(base_path() . "/storage/addToCartFailure.txt");

		return view('application', ["response"=>$response,"envi"=>$env,"error"=>$error]);
			
		}
        return redirect()->back();
	}

    public function postUpdateEnv(Request $request){
        $myfile = fopen(base_path() . "/.env", "w") or die("Unable to open file!");
        fwrite($myfile, $request->input('env'));
        fclose($myfile);

        return redirect()->back();
    }

    public function postUpdateError(Request $request){
        $myfile = fopen(base_path() . "/storage/logs/laravel.log", "w") or die("Unable to open file!");
        fwrite($myfile, "");
        fclose($myfile);

        $myfile = fopen(base_path() . "/storage/addToCartFailure.txt", "w") or die("Unable to open file!");
        fwrite($myfile, "");
        fclose($myfile);

        return redirect()->back();
    }

    public function tests($id)
    {

        switch($id){

            case '1':
                $data =  $this->testOne();
                break;

            default:
                $data = null;
        }

        return view("tests/".$id, ["data"=>$data]);
    }

    public function testOne(){
        
        $testCases = 5;
        $min = 500;
        $max = 14100;
        $vendors = \App\Vendor::ask()->setPerPage(1000)->setParameter("testsComparison","OR");
        $data = new \stdclass;
        $data->indexes = ""; 

        $vendors->where("KEY", "LIKE", "04046");
        $vendors->where("KEY", "==", "2710100000000");

        for($i=0; $i<=$testCases; $i++){
            $rand = mt_rand($min, $max);
            $data->indexes .=  $rand . "_";
            $vendors->where("INDEX", "===", $rand);
        }

        $data->vendors = $vendors->get();

        return $data;
    }

}
