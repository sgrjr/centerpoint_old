<?php namespace App\Http\Controllers;

use Auth;
//use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inventory;
use App\StoredQueries;
use App\Helpers\Misc;

use App\Events\UserLoggedIn;
use App\RouteModel;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class IndexController extends Controller
{

    use \App\Models\Traits\AuthenticatesUsersTrait;

  protected function indexBlank(Request $request)
  {	

    $graphqlurl = '"graphqlurl":"'.\Config::get('cp')["GRAPHQL_URL"].'"';

    return view('client',[
      "initial_state" => '{'.$graphqlurl.',"viewer":{"csrftoken":"lAvmJP08YGxocRbbFTRTVP3jNpU66GOuuyszl94f","browse":[{"title":"Genre","items":[{"url":"\/search\/Romance\/category","text":"Romance","icon":null},{"url":"\/search\/Romance+Christian\/category","text":"Romance - Christian","icon":null},{"url":"\/search\/Romance+Historical\/category","text":"Romance - Historical","icon":null},{"url":"\/search\/Romance+Suspense\/category","text":"Romance - Suspense","icon":null},{"url":"\/search\/Fiction\/category","text":"Fiction","icon":null},{"url":"\/search\/Fiction+History\/category","text":"Fiction - History","icon":null},{"url":"\/search\/Fiction+General\/category","text":"Fiction - General","icon":null},{"url":"\/search\/Fiction+Historical\/category","text":"Fiction - Historical","icon":null},{"url":"\/search\/Fiction+Women\/category","text":"Fiction - Women","icon":null},{"url":"\/search\/Fiction+Adventure\/category","text":"Fiction - Adventure","icon":null},{"url":"\/search\/Fiction+Science\/category","text":"Fiction - Science","icon":null},{"url":"\/search\/Fiction+Christian\/category","text":"Fiction - Christian","icon":null},{"url":"\/search\/Fiction+Inspirational\/category","text":"Fiction - Inspirational","icon":null},{"url":"\/search\/Nonfiction\/category","text":"Nonfiction","icon":null},{"url":"\/search\/Nonfiction+Biography\/category","text":"Nonfiction - Biography","icon":null},{"url":"\/search\/Nonfiction+History\/category","text":"Nonfiction - History","icon":null},{"url":"\/search\/Mystery\/category","text":"Mystery","icon":null},{"url":"\/search\/Mystery+Thriller\/category","text":"Mystery - Thriller","icon":null},{"url":"\/search\/Mystery+Christian\/category","text":"Mystery - Christian","icon":null},{"url":"\/search\/Mystery+Cozy\/category","text":"Mystery - Cozy","icon":null},{"url":"\/search\/Western\/category","text":"Western","icon":null}]}],"catalog":{},"searchfilters":["TITLE","ISBN","AUTHOR","LISTPRICE"],"slider":{"height":"40vh","background_color":"#FFFFFF","slides":[{"image":"http:\/\/localhost\/img\/slider\/1_image.png","caption":"","link":null},{"image":"http:\/\/localhost\/img\/slider\/2_image.png","caption":null,"link":"http:\/\/dev.centerpointlargeprint.com\/isbn\/9781643582153"},{"image":"http:\/\/localhost\/img\/slider\/3_image.png","caption":null,"link":null},{"image":"http:\/\/localhost\/img\/slider\/4_image.png","caption":null,"link":null}]},"links":{"main":[{"url":"\/","text":"Home","icon":"home"},{"url":"\/login","text":"Login","icon":"lockOpen"}],"drawer":[{"url":"\/login","text":"Login","icon":"lockOpen"},{"url":"#","text":"CP Connection","icon":"none"},{"url":"#","text":"Catalogues, Flyers","icon":"none"}]},"user":{"key":"false","name":null,"email":null,"authenticated":false,"token":null,"photo":"\/img\/profile-photo\/","vendor":null}}}'
    ]);
  }

protected function old(Request $request){

$vendor = (new \App\Models\Vendor)->odbc("select * from vendor")->echo();

  /*
  $params = new \stdclass;
  $params->tests = [['ISBN','LIKE','99']];
  $params->testsComparison = "COUNT";

  $table = (new \App\Models\Inventory)->entries($params);
  dd($table);
*/
// Microsoft SQL Server using the SQL Native Client 10.0 ODBC Driver - allows connection to SQL 7, 2000, 2005 and 2008
 //Storing DSN(Data Source Name created)

  $user="root";
  $password="";
  $server = "localhost";
  $driver = "Microsoft FoxPro VFP";
  $database = "VisualFoxProTables";
  $dsn = "WEBDBFs";

  $connection = "DSN=$dsn; DRIVER=$driver; SERVER=$server; DATABASE=$database; SourceType=DBF;SourceDB=R:\\zzRWDATA\\;Exclusive=No;Collate=Machine;NULL=NO;DELETED=NO;BACKGROUNDFETCH=NO";
  $conn = \odbc_connect($connection, $user, $password);
 
  //Checking connection id or reference
  if (!$conn)
   {
   echo (die(odbc_error()));
   }
   else
  {
    $sql = "SELECT * FROM vendor";
      $rs=odbc_exec($conn,$sql);
      var_dump($rs);
      echo "Connection Successful !";
  }
  //Resource releasing
  odbc_close($conn);

  die;
  $conn = new \COM("ADODB.Connection") or die("Cannot start ADO"); 
  $conn->Open('Provider=vfpoledb;Data Source="C:\\resources\\data\\Stephen_Reynolds\\WEBINFO\\RWDATA;";');

  $rs = $conn->Execute("SELECT * FROM webhead");
dd($rs);

    return view('app-old',[]);
  }

  protected function dbf(Request $request)
    {   

      $vars = [
        "input" => [
          "id"=> 4773,
          "PROD_NO" => 9781984841537,
          "REQUESTED" => 10,
          "REMOTEADDR" => "164674587001060"
        ]
      ];
      $user = \App\Models\User::find(1);

      $result = \App\Models\Webdetail::where("id",4773)->first()->dbfDelete();

      //$web = \App\Models\Webhead::where("INDEX",230)->first();
      //$web->PO_NUMBER = "999";
     
      //$mod = $web->dbfSave();

      echo "<h1>Write Log</h1><ol>";
      $log = json_decode(file_get_contents("DBF_WRITES.txt"));

      if($log !== null){
        foreach($log AS $entry){
          echo "<li style='border-bottom:solid 1px gray;'>".$entry->string."</li>";

          if(isset($entry->more->index)){
            $dbf = new \App\Ask\DatabaseType\XBaseTable($entry->file_name, true);
            $dbf->moveTo($entry->more->index);
            echo "<div>".$dbf->getRecord()->serialize()."</div>";
            $dbf->close();
          }

          echo "<p>SENT/WRITTEN [".$entry->time_stamp." - ".strlen($entry->string)." - ".$entry->file_name." - ".json_encode($entry->more)."]</p>";
        }
      }
      echo "</ol>";
    }

    protected function index(Request $request)
    {	

      $initial_state = '{}';
	    return view('react_app',[
          "initial_state" => json_encode($initial_state),
          "data" => $initial_state
        ]);
    }

    protected function isbn(Request $request, $isbn)
    {	
        $initial_state = new \stdclass;
        $initial_state->graphqlurl = \Config::get('cp')["GRAPHQL_URL"];
        
		    return view('client',[
          "initial_state" => json_encode($initial_state) 
        ]);
    }


     protected function success(Request $request)
    {

        return view('success', [
          "redirect" => $request->get('submitSuccess')
        ]);

    }
	
	    protected function search(Request $request, $string = false, $category = false)
    {	
    /*
        if(!$string){$string = 'CENTE';}
        if(!$category){$category = 'INVNATURE';}

      $query = 'query {    viewer {      search: titles(page: 1, perPage: 20, filters: {'.$category.':"'.$string.'",STATUS:"!=_Out Of Print"}) {        INDEX        ISBN        TITLE        PICLOC        INVNATURE        LISTPRICE        defaultImage        CAT        AUTHOR        FORMAT        SOPLAN        PUBDATE        STATUS        PUBLISHER      }    }  }';

    $initial_state = Misc::query($request, $query);
    $initial_state->graphqlurl = \Config::get('cp')["GRAPHQL_URL"];
    */
    $initial_state = '{viewer:{user:{vendor:{carts:[]}}}}';

	    return view('home',[
          "initial_state" =>$initial_state ,
          "data" =>  json_decode($initial_state)
        ]);
    }
	
	protected function postSearch(Request $request)
    {
		$string = $request->input('string')? $request->input('string'):"love";
    $category = $request->input("search_categories");
		return redirect("search/" . $string . "/". $category);

    }
	
	public function show(Request $request, $isbn)
    {

      $input = $request->all();
      $title = \App\Inventory::ask();

      if($title->source() !== "dbf"){
        $title = $title->find($isbn);
      }else{

          if( isset($input["index"]) && $input["index"] !== null && $input["index"] !== ""){
            $title = $title->findByIndex($input["index"]);
          }else{
            $title = $title->find($isbn);
          }

      }

        $authorTitles = \App\Inventory::ask()
          ->where("AUTHORKEY","===", $title->AUTHORKEY)
          ->setPerPage(10)
          ->get();

        $genreTitles = \App\Inventory::ask()
          ->where("CAT","===", $title->CAT)
          ->setPerPage(10)
          ->get();

          $booktext = \App\Booktext::ask()->where("KEY","===",$isbn)->get();

      if($booktext->paginator->count >= 1){
        $booktext = $booktext->records;
      }else{
        //$booktext1 = new \stdclass;
        //$booktext1->body =  new \stdclass;
        //$booktext1->body->subject = "Summary";
        //$booktext1->body->body = $title->summary;
        //$booktext1->body->type = "SUMMARY";
        $booktext = [];
      }

        return view('book', [
          "title"=> $title,
          "authorTitles"=>$authorTitles->records,
          "booktext" => $booktext,
          "genreTitles"=>$genreTitles->records
        ]);
    }


    public function logs(Request $request){
      //\App\Request::truncate();


      return view('log', [
        "items"=> \App\Request::all()
      ]);
    }

    public function marc(Request $request, $file){
        $append = "";
        if (strpos($file,".mrc") === false && strpos($file,".txt") === false){
          $append = ".mrc";
        }

          if(strpos($file,".mrc") === true || $append == ".mrc"){
            $path = \Config::get('cp')['marc_records_path'] . '/' . $file . $append;
          }else{
            $path = \Config::get('cp')['text_marc_records_path'] . '/' . $file;
          }
          $headers = [];

        try {
          return response()->download($path, $file.$append, $headers);
        }

        catch(\Throwable $e){
          return response()->download(public_path() .DIRECTORY_SEPARATOR."marcs".DIRECTORY_SEPARATOR."missing.mrc", "missing-".$file.".txt");
        }
    }

    public function file(Request $request, $file){

        if(strpos($file, "catalog") !== null){
          $args = ["id"=>$file];
          $s = \App\Helpers\Application::catalog($args);
          $path = $s->pdf_path;
          $headers = [];
        }else{
          $path = base_path() . '/app-js/build/static/' . $file;
          $headers = [];
        }

        try {
          return response()->file($path, $headers);
        }

        catch(\Throwable $e){
          abort(404, $e->getMessage());
        }
    }

    
	    public function test(Request $request){
            $user = \App\User::first();
            event(new UserLoggedIn($user));
            echo \App\Helpers\Test::log();
            return true;
        }

    protected function vue(Request $request)
    {	
    
    $data =  \App\Helpers\Misc::api(['user'=>auth('api')->user()])->content();


	    return view('vue',[
          "data" => $data
        ]);
    }

    protected function manual(Request $request)
    {

    $testId = 0;

      if($request->has('test')){

        $testId = $request->get('test');

        switch($testId){

          case 1:
            $response = RouteModel::data('/');
            break;

          case 2:
            $response = RouteModel::data('/random');
            break;

          case 3:
            $response = RouteModel::userLogin($request->get('email'), $request->get('password'));
            break;

          default:
            $response = 'test with id '. $testId .' is unset';
        }

        
      }else{
        $response = 'null';
      }

        return view('tests.manual', [
          "response" => $response,
          'id'=>$testId
        ]);

    }

    public function files($name){

      switch($name){

        case 'inventory-json':
            $data = \App\Helpers\Application::dbfToJSON('inventory');
            break;

        case 'inventory-csv':
            $fileName = 'inventory.csv';
            $records = Inventory::with('text')->limit(10000)->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = [
        //"handleId","fieldType",
        //"name","description"
        /*,
        "productImageUrl","collection","sku","ribbon","price","surcharge","visible","discountMode","discountValue","inventory","weight","productOptionName1","productOptionType1","productOptionDescription1","productOptionName2","productOptionType2","productOptionDescription2","productOptionName3","productOptionType3","productOptionDescription3","productOptionName4","productOptionType4","productOptionDescription4","productOptionName5","productOptionType5hproductOptionDescription5","productOptionName6","productOptionType6","productOptionDescription6","additionalInfoTitle1","additionalInfoDescription1","additionalInfoTitle2","additionalInfoDescription2","additionalInfoTitle3","additionalInfoDescription3","additionalInfoTitle4","additionalInfoDescription4","additionalInfoTitle5","additionalInfoDescription5","additionalInfoTitle6","additionalInfoDescription6","customTextField1","customTextCharLimit1","customTextMandatory1","customTextField2","customTextCharLimit2","customTextMandatory2"*/];

        $columns = collect($records[0]->getAttributes())->keys();
        $columns[]='description';

        $callback = function() use($records, $columns) {
            $file = fopen('php://output', 'w');

            fputcsv($file, $columns->toArray());

            foreach ($records as $record) {
                
                $row = [];

                foreach($columns AS $col){

                  if($col === "description"){
                    $des = '';

                    foreach($record["text"] AS $v){
                      $des .= $v['SYNOPSIS'] . " | ";
                    }
                     $row[$col]  = $des;   
                    
                  }else{
                     $row[$col]  = $record[$col];
                  }
                 
                }

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
            break;

        default:
          $data = null;
      }

      
    }

    public function filesIndex(){

        return view('files-index', [
          "links" => [
            ["text"=>"Inventory (CSV)","url"=>"/files/inventory-csv"],
            ["text"=>"Inventory (JSON)","url"=>"/files/inventory-json"]
          ],
        ]);
    }

}