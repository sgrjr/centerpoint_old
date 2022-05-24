<?php namespace App;

use Auth, Cache;
use Carbon\Carbon;
use App\Helpers\StringHelper;

class PermissionRequested {

	public $user, $request, $options, $can, $reason;

  public function __construct($user, $request, $options){

      $this->user = $user;
      $this->request = $request;
      $this->options = $options;

      $this->config = [
      	"VIEW_LOGIN",
      	"VIEW_REGISTER_USER",
      	"VIEW_DASHBOARD",
      	"VIEW_VENDORS",
      	"MODIFY_ADMIN_RESOURCE",
		    "ADMIN_APP"
      ];

      $this->validateRequest();

      $function = StringHelper::camelCase($this->request); 
   	call_user_func(array($this, $function));

   }

   private function validateRequest(){
   	 
   	 if(in_array($this->request, $this->config)){
   	 	return true;
   	 }else{
   	 	abort(403, 'Check your spelling Mr. Developer. '.$this->request.' has not be registered. ' . json_encode($this->config));
   	 }
   }

   private function setReason($value){
   	 $this->reason = $value;

      $log = ["user"=>$this->user->id, "request"=>$this->request, "options"=>$this->options, "can"=>$this->can, "reason"=> $this->reason];
	  $this->logIt($log);

	  return $this;
   }
   
   function defaultResponse(){
	  $this->can = false;
      $this->reason = "I_SAY_NO_TO_EVERYBODY_AT_FIRST";
   }

   function viewLogin(){
	  $this->can = ! $this->user->authenticated;

	  if($this->can){
	  	$this->setReason("YOU_ARE_NOT_LOGGED_IN_YET");
	  }else{
	  	$this->setReason("YOU_ARE_ALREADY_LOGGED_IN");
	  }
      
   }

   function viewDashboard(){
	  $this->can = $this->user->authenticated;

	  if($this->can){
	  	$this->setReason("YOU_ARE LOGGED_IN");
	  }else{
	  	$this->setReason("YOU_ARE_NOT_LOGGED_IN_YET");
	  }
      
   }

   function viewVendors(){
	   
	  if($this->user->hasRole('SUPER')){
        $this->can = true;
        $this->setReason("SUPER_USER_CAN_DO_ANYTHING");
      }else{
		$this->can = false;
		$this->setReason("NOT_ALLOWING_ANYONE_RIGHT_NOW");
	  }
   }
   
   function viewRegisterUser(){
	  if($this->user->hasRole('SUPER') && ! $this->user->authenticated){
        $this->can = true;
        $this->setReason("SUPER_USER_CAN_DO_ANYTHING");
      }else{
		$this->can = false;
		$this->setReason("NOT_ALLOWING_ANYONE_RIGHT_NOW");
	  }
   }

   function modifyAdminResource(){
	  if($this->user->hasRole('SUPER')){
        $this->can = true;
        $this->setReason("SUPER_USER_CAN_DO_ANYTHING");
      }else{
		$this->can = false;
		$this->setReason("NOT_ALLOWING_ANYONE_RIGHT_NOW");
	  }
   }  

   function adminApp(){
	  if($this->user->hasRole('SUPER')){
        $this->can = true;
        $this->setReason("SUPER_USER_CAN_DO_ANYTHING");
      }else{
		$this->can = false;
		$this->setReason("NOT_ALLOWING_ANYONE_RIGHT_NOW");
	  }
   }  
   
   	private function logIt($text)
	{
		//$this->logIt("User with credentials loaded from database.");
		
		if (Cache::has('ask')) {
		    $ask = Cache::get('ask');
		    $ask[] = $text;

		}else{
			$ask = [$text];
		}

		$expiresAt = Carbon::now()->addSeconds(61);

		Cache::put('ask', $ask, $expiresAt);
		//Cache::flush();
		return $this;
	}

}