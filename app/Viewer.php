<?php namespace App;

use \App\ViewerAuth;
use \App\ViewerAdmin;
use App\PermissionRequested;
use App\Helpers\Misc;

class Viewer {

    private $attributes = [];
    private $args = [];

    public function __construct($args = null)
    {
        $this
        ->initArgs($args);
    }

    public function preloadDBF($class, $key, $lists = false){
   
      if(!isset($this->dbfs[$key])){
        $val = $class::ask()
                ->skipModel(true)
                ->setPage(1)
                ->setPerPage(9999)
                ->orderBy("INDEX","DESC")
                ->lists($lists)
                ->get();

        $this->attributes["dbfs"][$key] = $val;
      }
      return $this;
    }

    public function loadTitles($args){

      if(isset($this->attributes['dbfs']['inventory'])){        
        $list = [];
        $parameters = \App\Helpers\Misc::defaultParameters($args);
        $count = 0;

        //$samecat = false;
        //$sameauthor = false;
  
        foreach($this->dbfs['inventory']->records AS $book){
       
          if(\App\Helpers\Compare::test($book, $parameters)){
            $count++;
            
            //if(isset( $this->dbfs['inventory']->lists['CAT'])){$samecat = $this->dbfs['inventory']->lists['CAT'][\App\Helpers\StringHelper::cleanKey($book["CAT"])];}
            //if(isset( $this->dbfs['inventory']->lists['AUTHORKEY'])){$sameauthor = $this->dbfs['inventory']->lists['AUTHORKEY'][$book["AUTHORKEY"]];}
            
            //$list[] = new Book($book, $samecat, $sameauthor);
            $list[] = new \App\Inventory($book);
            if($count === $parameters->perPage){break;}
          }
        }

        $this->attributes['titles'] = $list;
   
      }else{
        
        $class = \App\Inventory::class;

        if(isset($args['first']) && $args['first']){
          $this->attributes['titles'] = [$class::ask()->graphqlArgs($args, false)->first()];
        }else{
          $this->attributes['titles'] = $class::ask()->graphqlArgs($args, false)->get()->records;
        }
      }

      return $this;
    }

    private function initArgs($args)
    {
        $auth = \Request::bearerToken();

        if($auth !== null){
            $args['token'] = $auth;
        }

        $this->args = $args;
        $this->attributes['dbfs'] = [];
        $this->attributes['user'] = false;
        $this->attributes['standing_orders'] = false;
        $this->attributes['history'] = false;
        $this->attributes['isbns'] = false;

        if(isset($this->args['preload'])){
        
            $dbfs = [
                "inventory" => [\App\Inventory::class,"inventory",["CAT","AUTHORKEY","PUBDATE","INVNATURE"]]
            ];
            foreach($this->args['preload'] AS $dbf){
              $this->preloadDBF($dbfs[$dbf][0], $dbfs[$dbf][1], $dbfs[$dbf][2]);
			}
		}
        
        return $this;
    }

    private function initUser()
    {
        $this->attributes['user'] = ViewerAuth::getUser($this->args);
        return $this;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        $function = "get" . ucfirst($name);
        return $this->$function();
    }

    private function getAdmin()
    {
        return new ViewerAdmin($this->user);
    }

    public function getUser()
	{
        if(!$this->attributes["user"]){$this->initUser();}
        return $this->attributes["user"];
    }

    public function getTitles()
    {
      return $this->attributes["titles"];
      }

    public function getDbfs()
    {
      return $this->attributes["dbfs"];
    }

    public function getHistory()
    {
        if(!$this->attributes["history"]){$this->loadOrders();}
        return $this->attributes["history"];
    }

    public function getIsbns(){
      if(!$this->attributes["isbns"]){$this->loadOrders();}
      return $this->attributes["isbns"];
    }

    public function getStandingOrders(){
       if(!$this->attributes["standing_orders"]){$this->loadStandingOrders();}
       return $this->attributes["standing_orders"];
    }

    private function getSlider()
    {
        return \Config::get('slider_welcome');/*
        $i = 0;
        foreach($slider["slides"] AS $slide){
          $slider["slides"][$i]["image"] = "http://" . \Request::server('SERVER_NAME') . $slider["slides"][$i]["image"];
          $i++;
        }
        return $slider;*/
    }

    private function getCSRFToken(){
      return csrf_token();
    }

    private function getSearchFilters()
    {
        return ["TITLE","ISBN","AUTHOR","LISTPRICE"];
    }

    private function getBrowse()
    {
        return $this->getBrowseProducts();
    }

    private function getCurrentCatalog()
    {
         return static::promo()->image;
    }

    private function getCurrentCatalogLink()
    {
         return static::promo()->pdf;
    }

    public static function catalog($args){
     
      $config = \Config::get('cp');

      $cat = new \stdclass;
      $cat->id = null;
      $cat->image_root = $config["promotionspath"] . "/CP_COVERS_JPG/";
      $cat->pdf_root = $config["promotionspath"] . "/CP_CATALOGS_PDF/";
      $cat->image_link = "/img/promotions/current";
      $cat->image_path = null;
      $cat->image_ext = null;
      $cat->pdf_link = null;
      $cat->pdf_path = null;
      $cat->year = null;
      $cat->month = null;
      $cat->template = "original";
      

      if(isset($args['id'])){
        $cat->id = $args['id'];
      }

      $cat->list = [
        "01" => "01_02",
        "02" => "01_02",
        "03" => "03_04",
        "04" => "03_04",
        "05" => "05_06",
        "06" => "05_06",
        "07" => "07_08",
        "08" => "07_08",
        "09" => "09_10",
        "10" => "09_10",
        "11" => "11_12",
        "12" => "11_12"
      ];

      switch($cat->id){
        case "current":
        case "current_catalog":
        case "current_catalog_image":

        $search = \Cache::remember('catalog', 360, function () use($cat) {
            return Misc::findFileByDate($cat->image_root, $cat->list);
        });

          $cat->image_link = "/img/promotions/current_catalog";
          $cat->image_path = $search->image;	
          $cat->year = $search->year;
          $cat->month = $search->month;
          $cat->image_ext = $search->ext;
          $cat->pdf_link = "/static/current_catalog";
          $cat->pdf_path = $cat->pdf_root . $cat->year . "_" . $cat->month . ".pdf";
          break;
        
        case "next":
        case "next_catalog":
        case "next_catalog_image":
          $first = [
            sprintf("%04d",date("Y")),
            sprintf("%02d",date("m")+1)
          ];
          
          $search = \Cache::remember('next_catalog', 360, function () {
            return Misc::findFileByDate($cat->image_root, $cat->list);
          });
          
          $cat->image_link = "/img/promotions/next_catalog";
          $cat->image_path = $search->image;	
          $cat->year = $search->year;
          $cat->month = $search->month;
          $cat->image_ext = $search->ext;
          $cat->pdf_link = "/static/next_catalog";
          $cat->pdf_path = $cat->pdf_root . $cat->year . "_" . $cat->month . ".pdf";
        break;
  
        default:
          $cat->image_link = "/img/promotions/" . $cat->id;
          $cat->image_path = $config["promotionspath"] . "/" . $cat->id;	
          //$cat->year = $search->year;
          //$cat->month = $search->month;
          //$cat->image_ext = $search->ext;
          $cat->pdf_link = "/static/".$cat->id;
          //$cat->pdf_path = $cat->pdf_root . $cat->year . "_" . $cat->month . ".pdf";

            if(!file_exists($cat->image_path)){
              
              foreach($this->extensions AS $ext){
                if(file_exists($cat->image_path . $ext)){
                  $cat->image_path = $cat->image_path . $ext;
                  break;
                }else{
                  $cat->image_path = false;
                }
                
              }
              
            }
      
          
      } 
      return $cat;
    }

    private function getNextCatalog()
    {
         return '/img/promotions/next_catalog_image';
    }

    public function can($request, $options = false)
    {
      $response = new PermissionRequested($this->user, $request, $options);
      return $response->can;
    }

   public function getLinks(){
  
        $links = new \stdclass;
  
        $links->drawer = collect([]);
        $links->main = collect([]);
  
        $links->main->push(["url"=>"/", "text"=> 'Home',"icon"=>"home"]);
  
         if ($this->can("VIEW_DASHBOARD")){
          $links->drawer->push(["url"=>"/dashboard", "text"=> $this->user->name,"icon"=>"home"]);
          $links->main->push(["url"=>"/dashboard", "text"=> $this->user->name, "name"=>"brand","icon"=>"notifications"]);
         } 
  
        if ($this->can("VIEW_LOGIN")){
          $links->drawer->push([ "url"=>"/login", "text"=> 'Login',"icon"=>"lockOpen"]);
          $links->main->push([ "url"=>"/login", "text"=> 'Login',"icon"=>"lockOpen"]);
        }
                     
        $links->drawer->push([ "url"=>"#", "text"=> 'CP Connection',"icon"=>"none"]);
        $links->drawer->push([ "url"=>"#", "text"=> 'Catalogues, Flyers',"icon"=>"none"]);
  
        if ($this->can("VIEW_REGISTER_USER")){
          $links->drawer->push([ "url"=>"/register", "text"=> 'Register New User',"icon"=>"howToReg"]);
        }
  
        if ($this->can("VIEW_DASHBOARD")){
          $links->drawer->push([ "url"=>"/logout", "text"=> 'Logout', "name"=>"logout","icon"=>"lock"]);
          $links->main->push([ "url"=>"/logout", "text"=> 'Logout', "name"=>"logout","icon"=>"lock"]);
        }
  
        if ($this->can("ADMIN_APP")){
          $links->drawer->push([ "url"=>"/admin", "text"=> 'Admin',"icon"=>"HEADING"]);
          $links->drawer->push([ "url"=>"/admin/inventories", "text"=> 'Inventory',"icon"=>"dashboard"]);
          $links->drawer->push([ "url"=>"/admin/vendors", "text"=> 'Vendors',"icon"=>"dashboard"]);
          $links->drawer->push([ "url"=>"/admin/db", "text"=> 'Database',"icon"=>"dashboard"]);
          $links->drawer->push([ "url"=>"/admin/orders", "text"=> 'Orders',"icon"=>"dashboard"]);
          $links->drawer->push([ "url"=>"/admin/application", "text"=> 'Application',"icon"=>"dashboard"]);
        }
  
        return $links;
  
      }

    public function getBrowseProducts(){
      return \Cache::rememberForever('browse_products', function () {
          return $this->calcBrowseProducts();
      }); 
  }

    private function calcBrowseProducts(){
          
        $cats = ["Romance","Romance - Christian","Romance - Historical","Romance - Suspense",
            "Fiction",
            "Fiction - History", 
            "Fiction - General",
            "Fiction - Historical",
            "Fiction - Women",
            "Fiction - Adventure",
            "Fiction - Science",
            "Fiction - Christian",
            "Fiction - Inspirational",
            "Nonfiction",
            "Nonfiction - Biography",
            "Nonfiction - History",
            "Mystery",
            "Mystery - Thriller",
            "Mystery - Christian",
            "Mystery - Cozy",
            "Western"
        ];
        
        $genre_items = [];

        foreach($cats AS $cat){
            $genre_items[] = \App\Helpers\Misc::makeSearchUrl($cat, "CAT");
        }
        
        $months = [
          \App\Helpers\Misc::makeSearchUrl("202003", "PUBDATE", "2020 March"),
          \App\Helpers\Misc::makeSearchUrl("202004", "PUBDATE", "2020 April"),
          \App\Helpers\Misc::makeSearchUrl("202005", "PUBDATE", "2020 May")
        ];

        return [
                    ["title"=>"Search By Month","items"=>$months],
                    ["title"=>"Genre", "items"=> $genre_items]
                ];
  }

        public function loadOrders(){

            if($this->attributes['history'] === false){
    			    $this->attributes['history']  = $this->user->vendor->orderItems;
    			    $this->attributes['isbns']  = [];

    			    foreach($this->history AS $book){
    				    $this->attributes['isbns'][] = $book->ISBN;
    			    }
            }
			return $this;
		}

		public function loadStandingOrders(){
      if($this->attributes['standing_orders'] !== false){
        return $this;     
			}
	
         $this->attributes['standing_orders']  = \App\StandingOrder::ask()->where("KEY","===", $this->user->vendor->KEY)->get()->records;	
		    return $this;
		}
  
}