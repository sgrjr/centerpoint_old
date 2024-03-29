<?php namespace App\Helpers;

use Auth, Cache;
use Carbon\Carbon;
use App\Helpers\StringHelper;

class PermissionRequested {

	public $user, $request, $options, $can, $reason;

  public function __construct($user, $request, $options){

      $this->user = $user;
      $this->request = $request;
      $this->options = $options;

      $this->config = \App\Models\Permission::all()->toArray();

      $this->validateRequest();
      $function = StringHelper::camelCase($this->request); 
   		call_user_func(array($this, $function));

   }

   private function validateRequest(){
   	 $permission_exists = false;

   	 foreach ($this->config as $permission) {
		    if (strpos($this->request, $permission["name"]) !== FALSE) {
		        $permission_exists = true;
		    }
			}

   	 if($permission_exists){
   	 	return true;
   	 }else{
		return true;
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

   function viewDashboard(){

	  $this->can = true;
    $this->setReason("YOU_ARE LOGGED_IN");   
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

	  if($this->user->hasRole('SUPER')){
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

   function listAllUsers(){
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