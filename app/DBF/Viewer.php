<?php namespace App\DBF;

use GraphQLRelay\Relay;
use App\Relay\Support\PaginatedCollection;
use App\Relay\Support\GraphQLGenerator;
use App\Relay\Schema\AppSchema;

use App\DBF\Input;
use App\User;
use App\DBF\Inventory;
use App\DBF\Payload;
use App\DBF\DBFDatabase AS Database;
use App\DBF\QueryObject;

use stdClass, JWTAuth;

class Viewer {

   public $request, $payload, $user;
   private $db;
   
   function __construct($request){
		$this->boot($request); 
  }
  
   private function boot($request){
        $this->setRequest($request)
            ->setDB()
            ->setPayload();
   }
  
   private function setRequest($request){
        $this->request = $request; 	
		return $this;
   }
  
   private function setDB(){
	    $this->db = Database::build(config('cp'));
		return $this;
   }

  public function setUser(){

    if(isset($this->request->variables["token"])){

    }else if(isset($this->request->variables["email"]) & isset($this->request->variables["password"])){
        $email = $this->request->variables["email"];
        $password = $this->request->variables["password"];
        //$userId = "9250900000000";

        $query = (new QueryObject)
            ->setTable("password")
            ->setSelect("*")
            ->setWhere([["UPASS","===",$password],["EMAIL","===",$email]])
            ->setLimit(1);

       $table = $this->db->query($query);       
       $attributes = array_merge($table[0], [
          "authenticated"=>true
       ]);

       $userId = trim($table[0]["KEY"]);

       $query2 = (new QueryObject)
            ->setTable("vendor")
            ->setSelect("*")
            ->setWhere([["KEY","===",$userId]])
            ->setLimit(1);

      $table2 = $this->db->query($query2);
      $attributes = array_merge($attributes, $table2[0]);

      $query3 = (new QueryObject)
            ->setTable("password")
            ->setSelect("*")
            ->setWhere([["KEY","===",$userId]])
            ->setLimit(1);

      $table3 = $this->db->query($query3);

      $attributes = array_merge($attributes, $table3[0]);



      $this->user = new User($attributes);
      $this->user->token = $this->createToken();
    }

	   return $this;        
  }
  
   public function createToken()
      {   
          return JWTAuth::fromUser($this->user);
      }

 public static function getAuth($token = null){

            $a = new stdClass;
            $a->error = new stdClass;
            $a->token = str_replace('Bearer ','', $token);;
            $a->user = User::getGuest();
            $a->myNotes = null;

          try {
               $auth = \JWTAuth::setToken($a->token);
           }catch(JWTException $e){
               $a->error->message= $e->getMessage();
               $a->error->code = $e->getCode();
               return $a;
           }



           try {

                   if (! $user = $auth->authenticate()) {
                        $a->error->message= 'user_not_found';
                        $a->error->code = 404;
                   }else{
                     $a->user = $user;
                      $a->error->message= 'Ok';
                      $a->error->code = 200;
                    }

               } catch (\App\JWT\Exceptions\TokenExpiredException $e) {
                    $a->error->message= 'token_expired';
                    $a->error->code = $e->getStatusCode();
                } catch (\App\JWT\Exceptions\TokenInvalidException $e) {
                    $a->error->message= 'token_invalid';
                    $a->error->code = $e->getStatusCode();
                } catch (\App\JWT\Exceptions\JWTException $e) {
                    $a->error->message= $e->getMessage();
                    $a->error->code = $e->getStatusCode();
                } finally {
                    $a->myNotes = $a->user->notes;
                    return $a;
                }

                return $this;

       }
	private function setPayload(){

        $this->payload = AppSchema::ask($this);
        unset($this->db);
        return $this;
         
	}
}

