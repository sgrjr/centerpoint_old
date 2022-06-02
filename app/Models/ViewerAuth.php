<?php namespace App\Models;

use Auth;
use \App\Models\User;

class ViewerAuth {
    public static function getUser($args){
    
        if(isset($args) && count($args) > 0){
             $that = new static;
             
            if(isset($args['vendorkey'])){
                
                $v = \App\Models\Vendor::ask()->where('KEY','===',$args['vendorkey'])->get();
                
                if($v->paginator->count <= 0){
                    $user = \App\Models\User::where('key',$args['vendorkey'])->first();
                    Auth::login($user);
                    return Auth::user();
				}

                $email = $v->getCredentialsConnection()->records[0]->EMAIL;
                $password = $v->getCredentialsConnection()->records[0]->UPASS;       

                return $that->login(['email'=>$email, 'password'=>$password]);
			}
            return $that->login($args);

		}else{

            if(\Auth::check()){
                return \Auth::user();
            }else{
                return \App\Models\User::getGuest();
            }

	    }
    }

    public function login($creds)
    {
        $this->validateLogin($creds);
        $attempt = $this->attemptLogin($creds);

        if ($attempt) {
            return $attempt;
        }

        return  User::getGuest();

    }

    protected function validateLogin($credentials)
    {
        return true;
    }

    protected function attemptLogin($credentials)
    {
        
        $credentials =  $this->credentials($credentials);

        if(is_array($credentials)){
            
        		$attempt = Auth::attempt($credentials);
             
        		if($attempt){
        			return Auth::user();
        		}

	            $passwordTable = User::getCredentialsFromTable($credentials);

	            if($passwordTable !== null){
	            	$user = \App\Models\User::where("email","===",$credentials["email"])->first();

	            	if($user === null){
	            		$user = User::createCredentialsFromPasswordsTable($credentials);
	            	}

                    Auth::login($user);
                    return Auth::user();
	            }

	    }else{
        	$user = User::where("api_token",$credentials)->first();

        	if($user !== null){
                Auth::login($user);
        		return Auth::user();
        	}
        }

        return false;
        
    }
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials($creds)
    {
    	
    	if(isset($creds["email"]) && isset($creds["password"]) && isset($creds["token"])){
    		unset($creds["token"]);
    	}else if(!isset($creds["email"]) && !isset($creds["password"]) && isset($creds["token"])){
            return $creds["token"];
        }

        return $creds;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}
