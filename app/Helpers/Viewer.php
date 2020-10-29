<?php namespace App\Helpers;

use \App\Helpers\ViewerAuth;
use \App\Helpers\ViewerAdmin;

use App\Helpers\Misc;
use Request;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Viewer {

    public $me;
    public $titles;
    public $title;
    public $cpTitles;
    public $tradeTitles;
    public $advancedTitles;


    public function __construct(\App\User $me)
    {
        $this->me = $me;
    }

    public function getMe(){
        return $this->me;
    }

    private function init($rootValue, $args, $context, $resolveInfo){
        $this->root = $rootValue;
        $this->args = $args;
        $this->context = $context;
        $this->resolveInfo = $resolveInfo;
        //$this->authenticated = true;
        $this->props = ['authenticated' => false];
        return $this;
    }

    private function getProps(){
      return $this->props;
    }

    public function setTokenFromRequest(){
        $auth = \Request::bearerToken();
        $this->attributes['token'] = $auth;
        return $this;
	}

    private function initArgs($args, $token)
    {
        $this->args = $args;
        $this->attributes['dbfs'] = [];
        $this->attributes['token'] = $token;
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

    private function getAuthenticated(){
        return ViewerAuth::isAuthenticated();
	}

    private function initUser()
    {
        $this->attributes['user'] = ViewerAuth::getUser();
        return $this;
    }

    private function getToken(){
        return $this->attributes["token"];
	}

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {die;
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