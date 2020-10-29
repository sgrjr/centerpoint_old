<?php namespace App\Http\Controllers;

use Auth;
//use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inventory;
use App\StoredQueries;
use App\Helpers\Misc;
<<<<<<< HEAD
use App\Events\UserLoggedIn;
use App\RouteModel;
=======
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

class IndexController extends Controller
{

<<<<<<< HEAD
    use \App\Core\AuthenticatesUsersTrait;

  protected function indexBlank(Request $request)
  {	

    $graphqlurl = '"graphqlurl":"'.\Config::get('cp')["GRAPHQL_URL"].'"';

    return view('client',[
      "initial_state" => '{'.$graphqlurl.',"viewer":{"csrftoken":"lAvmJP08YGxocRbbFTRTVP3jNpU66GOuuyszl94f","browse":[{"title":"Genre","items":[{"url":"\/search\/LIKE_Romance\/CAT","text":"Romance","icon":null},{"url":"\/search\/LIKE_Romance+Christian\/CAT","text":"Romance - Christian","icon":null},{"url":"\/search\/LIKE_Romance+Historical\/CAT","text":"Romance - Historical","icon":null},{"url":"\/search\/LIKE_Romance+Suspense\/CAT","text":"Romance - Suspense","icon":null},{"url":"\/search\/LIKE_Fiction\/CAT","text":"Fiction","icon":null},{"url":"\/search\/LIKE_Fiction+History\/CAT","text":"Fiction - History","icon":null},{"url":"\/search\/LIKE_Fiction+General\/CAT","text":"Fiction - General","icon":null},{"url":"\/search\/LIKE_Fiction+Historical\/CAT","text":"Fiction - Historical","icon":null},{"url":"\/search\/LIKE_Fiction+Women\/CAT","text":"Fiction - Women","icon":null},{"url":"\/search\/LIKE_Fiction+Adventure\/CAT","text":"Fiction - Adventure","icon":null},{"url":"\/search\/LIKE_Fiction+Science\/CAT","text":"Fiction - Science","icon":null},{"url":"\/search\/LIKE_Fiction+Christian\/CAT","text":"Fiction - Christian","icon":null},{"url":"\/search\/LIKE_Fiction+Inspirational\/CAT","text":"Fiction - Inspirational","icon":null},{"url":"\/search\/LIKE_Nonfiction\/CAT","text":"Nonfiction","icon":null},{"url":"\/search\/LIKE_Nonfiction+Biography\/CAT","text":"Nonfiction - Biography","icon":null},{"url":"\/search\/LIKE_Nonfiction+History\/CAT","text":"Nonfiction - History","icon":null},{"url":"\/search\/LIKE_Mystery\/CAT","text":"Mystery","icon":null},{"url":"\/search\/LIKE_Mystery+Thriller\/CAT","text":"Mystery - Thriller","icon":null},{"url":"\/search\/LIKE_Mystery+Christian\/CAT","text":"Mystery - Christian","icon":null},{"url":"\/search\/LIKE_Mystery+Cozy\/CAT","text":"Mystery - Cozy","icon":null},{"url":"\/search\/LIKE_Western\/CAT","text":"Western","icon":null}]}],"catalog":{},"searchfilters":["TITLE","ISBN","AUTHOR","LISTPRICE"],"slider":{"height":"40vh","background_color":"#FFFFFF","slides":[{"image":"http:\/\/localhost\/img\/slider\/1_image.png","caption":"","link":null},{"image":"http:\/\/localhost\/img\/slider\/2_image.png","caption":null,"link":"http:\/\/dev.centerpointlargeprint.com\/isbn\/9781643582153"},{"image":"http:\/\/localhost\/img\/slider\/3_image.png","caption":null,"link":null},{"image":"http:\/\/localhost\/img\/slider\/4_image.png","caption":null,"link":null}]},"links":{"main":[{"url":"\/","text":"Home","icon":"home"},{"url":"\/login","text":"Login","icon":"lockOpen"}],"drawer":[{"url":"\/login","text":"Login","icon":"lockOpen"},{"url":"#","text":"CP Connection","icon":"none"},{"url":"#","text":"Catalogues, Flyers","icon":"none"}]},"user":{"key":"false","name":null,"email":null,"authenticated":false,"token":null,"photo":"\/img\/profile-photo\/","vendor":null}}}'
    ]);
  }

    protected function index(Request $request)
    {	

    $initial_state = '{}';
	    return view('home',[
          "initial_state" => json_encode($initial_state),
          "data" => $initial_state
=======
  protected function indexBlank(Request $request)
  {	

    $graphqlurl = '"graphqlurl":"'.\Config::get('cp')["GRAPHQL_URL"].'"';

    return view('client',[
      "initial_state" => '{'.$graphqlurl.',"viewer":{"csrftoken":"lAvmJP08YGxocRbbFTRTVP3jNpU66GOuuyszl94f","browse":[{"title":"Genre","items":[{"url":"\/search\/LIKE_Romance\/CAT","text":"Romance","icon":null},{"url":"\/search\/LIKE_Romance+Christian\/CAT","text":"Romance - Christian","icon":null},{"url":"\/search\/LIKE_Romance+Historical\/CAT","text":"Romance - Historical","icon":null},{"url":"\/search\/LIKE_Romance+Suspense\/CAT","text":"Romance - Suspense","icon":null},{"url":"\/search\/LIKE_Fiction\/CAT","text":"Fiction","icon":null},{"url":"\/search\/LIKE_Fiction+History\/CAT","text":"Fiction - History","icon":null},{"url":"\/search\/LIKE_Fiction+General\/CAT","text":"Fiction - General","icon":null},{"url":"\/search\/LIKE_Fiction+Historical\/CAT","text":"Fiction - Historical","icon":null},{"url":"\/search\/LIKE_Fiction+Women\/CAT","text":"Fiction - Women","icon":null},{"url":"\/search\/LIKE_Fiction+Adventure\/CAT","text":"Fiction - Adventure","icon":null},{"url":"\/search\/LIKE_Fiction+Science\/CAT","text":"Fiction - Science","icon":null},{"url":"\/search\/LIKE_Fiction+Christian\/CAT","text":"Fiction - Christian","icon":null},{"url":"\/search\/LIKE_Fiction+Inspirational\/CAT","text":"Fiction - Inspirational","icon":null},{"url":"\/search\/LIKE_Nonfiction\/CAT","text":"Nonfiction","icon":null},{"url":"\/search\/LIKE_Nonfiction+Biography\/CAT","text":"Nonfiction - Biography","icon":null},{"url":"\/search\/LIKE_Nonfiction+History\/CAT","text":"Nonfiction - History","icon":null},{"url":"\/search\/LIKE_Mystery\/CAT","text":"Mystery","icon":null},{"url":"\/search\/LIKE_Mystery+Thriller\/CAT","text":"Mystery - Thriller","icon":null},{"url":"\/search\/LIKE_Mystery+Christian\/CAT","text":"Mystery - Christian","icon":null},{"url":"\/search\/LIKE_Mystery+Cozy\/CAT","text":"Mystery - Cozy","icon":null},{"url":"\/search\/LIKE_Western\/CAT","text":"Western","icon":null}]}],"catalog":{},"searchfilters":["TITLE","ISBN","AUTHOR","LISTPRICE"],"slider":{"height":"40vh","background_color":"#FFFFFF","slides":[{"image":"http:\/\/localhost\/img\/slider\/1_image.png","caption":"","link":null},{"image":"http:\/\/localhost\/img\/slider\/2_image.png","caption":null,"link":"http:\/\/dev.centerpointlargeprint.com\/isbn\/9781643582153"},{"image":"http:\/\/localhost\/img\/slider\/3_image.png","caption":null,"link":null},{"image":"http:\/\/localhost\/img\/slider\/4_image.png","caption":null,"link":null}]},"links":{"main":[{"url":"\/","text":"Home","icon":"home"},{"url":"\/login","text":"Login","icon":"lockOpen"}],"drawer":[{"url":"\/login","text":"Login","icon":"lockOpen"},{"url":"#","text":"CP Connection","icon":"none"},{"url":"#","text":"Catalogues, Flyers","icon":"none"}]},"user":{"key":"false","name":null,"email":null,"authenticated":false,"token":null,"photo":"\/img\/profile-photo\/","vendor":null}}}'
    ]);
  }
    protected function index(Request $request)
    {	

      $query = 'query {
  viewer {
    csrftoken
    browse {
      title
      items {
        url
        text
        icon
      }
    }
    catalog (id:"current_catalog"){
      image_link
      pdf_link
    }
    searchfilters
    slider {
      height
      background_color
      slides {
        image
        caption
        link
      }
    }
    links {
      main {
        url
        text
        icon
      }
      drawer {
        url
        text
        icon
      }
    }
    user {
      key
      name
      authenticated
      token
    }
  }
}
';
    
    $initial_state = Misc::query($request, $query);
    $initial_state->graphqlurl = \Config::get('cp')["GRAPHQL_URL"];

	    return view('client',[
          "initial_state" => json_encode($initial_state)
        ]);
    }

    protected function isbn(Request $request, $isbn)
    {	

      $query = 'query ($isbn:String) {
        viewer {
          title(filters: {ISBN: $isbn}) {
            LISTPRICE
            INDEX
            AUTHOR
            AFIRST
            ALAST
            SUFFIX
            AUTHORKEY
            ISBN
            TITLE
            FORMAT
            SUBTITLE
            HIGHLIGHT
            PICLOC
            CAT
            AUTHORKEY
            INVNATURE
            PAGES
            PUBDATE
            STATUS
            defaultImage
            text {
              body {
                type
                subject
                body
              }
            }         
          }
        }
      }  
';
        $initial_state = \App\Helpers\Misc::query($request, $query);

        $initial_state->graphqlurl = \Config::get('cp')["GRAPHQL_URL"];
		    return view('client',[
          "initial_state" => json_encode($initial_state) 
        ]);
    }

     protected function success(Request $request)
    {

        return view('success', [
          "redirect" => $request->get('submitSuccess')
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
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
<<<<<<< HEAD

     protected function success(Request $request)
    {

        return view('success', [
          "redirect" => $request->get('submitSuccess')
        ]);
=======
	
	protected function search(Request $request, $string=false, $category = false)
    {
        
      if($request->page === null){
        $page = 1;
      }else{
        $page = $request->page;
      }

      if($category !== false){
        $cat = $category;
      }else{
        $cat = "TITLE";
      }

      if(!$string){
        $string = "love";
      }

      $string = str_replace("+"," ", $string);
      $stringList =[];

      foreach(explode(" ", $string) AS $s){
        if(ctype_alpha(substr(trim($s), 0)) ){
          $stringList[]=trim($s);
        }
      }
        
      //TITLES
      $titles = \App\Inventory::ask();

      foreach($stringList AS $s){
        $titles->where($cat,"LIKE", "%{$s}%");
      }
        
        $titles = $titles->setPerPage(20)
            ->setPage($page)
            ->get();

      if($titles->paginator->count === 1){
        return redirect("isbn/" . $titles->records[0]->isbn);
      }else{
        return view('search', ["titles"=> $titles->records, "search"=>$string, "searchCategory"=>$cat, "paginator"=>$titles->paginator]);
      }
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

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
<<<<<<< HEAD

      return view('log', [
        "items"=> \App\Request::all()
      ]);
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

=======

      return view('log', [
        "items"=> \App\Request::all()
      ]);
    }

    public function file(Request $request, $file){

        if(strpos($file, "catalog") !== null){
          $args = ["id"=>$file];
          $s = \App\Viewer::catalog($args);
          $path = $s->pdf_path;
          $headers = [];
        }else{
          $path = base_path() . '/app-js/build/static/' . $file;
          $headers = [];
        }
        
        return response()->file($path, $headers);
    }
	
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
}