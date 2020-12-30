<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth, Session;
use App\Helpers\DatabaseManager;
use App\Dbf;
use App\Command;

class AdminController extends Controller
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

		$commandHistory = Command::all();

		$dm = new DatabaseManager();

        return view('admin.database', [
			"commandHistory"=>$commandHistory,
			"registeredDbfs"=>$dm->files, 
			"tables"=>$dm->tables,
			"commands"=> $dm->commands,
      "user"=> Auth::user()

			]);
    }
	
	public function command(Request $request)
    {
		$dm = new DatabaseManager();
        $user = \Auth::user();

		if($user->can("ADMIN_APP")){
			$command = $dm->execute($request, $user->user);
			return redirect()->back();
		}
	}

    public function ask(Request $request, $table, $search = "small"){

         $class = "\App\\" . ucfirst(strtolower($table));

         switch($search){
            
            case 'small':
                $perPage = 5;
                break;

            case 'medium':
                $perPage = 3000;
                break;
            case 'all':
                $perPage = 99999999;
                break;

            default:
                $perPage = 5;
		 }

         $results = $class::ask()
                    ->skipModel(false)
                    ->setPage(1)
                    ->setPerPage($perPage)
                    ->orderBy("INDEX","DESC")
                    ->lists(["AUTHORKEY","CAT"])
                    ->get();
        
        $vars = $request->all();

        return view('admin.ask', [
            "results" => $results,
            "hide" => isset($vars["hide"])? $vars["hide"]:false
        ]);

	}

        public function viewDBF(Request $request, $dbf, $search = false){

        if(\App\Dbf::mysql()->count() < 1 ){

            $dm = new \App\Helpers\DatabaseManager;
            $rows = $dm->getTables();
            $dm->importList("dbfs", $rows);
        }

        $page = $request->input('page')? $request->input('page'): 1;
        
        if($search !== false) $search = json_decode($search);

        $dbf = DBF::where("name",$dbf)->first();

        $limit = 500;
        $model = new $dbf->model;
        $table = new $dbf->model;
        $offset = ($page-1);
        $data = new \stdclass;

       $model = $model->ask()
       //->setPage($offset) //disabled for now as causing problems
       ->setPerPage($limit);


        if($search !== false){
            foreach ($search AS $s){
                $model = $model->where($s[0],$s[1], $s[2] );
            }
        }

        $model = $model->get();
        $model->paginator->page = $page;

         return view('admin.dbf', [
            "table"=>$table,
            "records"=> $model->records,
            "paginator"=> $model->paginator
            ]);

    }

        public function search(Request $request){

         $page = $request->input('page')? $request->input('page'): 1;
         $dbf = DBF::where("name",$request->input("dbf"))->first();

        $limit = 100;
        $model = new $dbf->model;
        $table = new $dbf->model;
        $offset = ($page-1);
        $data = new \stdclass;

        $model = $model->ask()->setPage($offset)->setPerPage($limit);
        $model = $model->where($request->input("search_field"),"==", $request->input("search_value"));
        $model = $model->get();
        $model->paginator->page = $page;

         return view('admin.dbf', [
            "table"=>$table,
            "records"=> $model->records,
            "paginator"=> $model->paginator
            ]);

    }

        public function vendor(Request $request, $key){

        $vendor = \App\Vendor::ask()
        ->where("KEY","==", $key)
        ->first();

        $activeSo = $vendor->activeStandingOrders;

         return view('admin.vendor', [
            "vendor"=>$vendor,
            "vendorCreds"=>$vendor->getCredentialsConnection()->records,
            "standingOrders"=>$activeSo->records,
            "orders"=>$vendor->orders,
            "titles"=>\App\Inventory::ask()->all()->records
            ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($transno)
    {
              
      $order = \App\Order::where("TRANSNO",$transno)->first();

        return view('order', array_merge($order->invoiceVars(), [
          "user" => (new \App\Helpers\Viewer)->user
        ]));
    }
	
}
