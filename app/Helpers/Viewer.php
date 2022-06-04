<?php namespace App\Helpers;

use \App\Helpers\ViewerAuth;
use \App\Helpers\ViewerAdmin;

use App\Helpers\Misc;
use Request;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use \App\Models\StandingOrder;

class Viewer {
    
    public $props;

    public function __construct($user = null)
    { 
        $this->props = [];
        $this->me = $user;
    }

    private function getProps(){
        return $this->props;
    }

    public function getApplication(){
        return \App\Helpers\Application::props($this->user);
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
                "inventory" => [\App\Models\Inventory::class,"inventory",["CAT","AUTHORKEY","PUBDATE","INVNATURE"]]
            ];
            foreach($this->args['preload'] AS $dbf){
              $this->preloadDBF($dbfs[$dbf][0], $dbfs[$dbf][1], $dbfs[$dbf][2]);
			}
		}
        
        return $this;
    }

    private function getAuthenticated(){
        if(!$this->props['authenticated']){$this->props['authenticated'] = $this->me !== null && $this->me != false;}
        return $this->props['authenticated'];
	}

    private function getToken(){
        return $this->attributes["token"];
	}

    public function __set($name, $value)
    {
        $this->props[$name] = $value;
    }

    public function __get($name)
    {
        $function = "get" . ucfirst($name);
        if(method_exists($this, $function)){
            return $this->$function();
        }else if(isset($this->$name)){
            return $this->$name;
        }else{
            return null;
        }
    }

    private function getAdmin()
    {
        return new ViewerAdmin($this->user);
    }

    public function getUser()
	{
        return $this->props['me'];
    }

    public function getTitles()
    {
      return $this->props["titles"];
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
	
         $this->attributes['standing_orders']  = StandingOrder::ask()->where("KEY","===", $this->user->vendor->KEY)->get()->records;	
		    return $this;
		}
  
}