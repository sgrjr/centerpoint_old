<?php

namespace App\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\User;
use App\Events\UserLoggedIn;

trait AuthenticatesUsersTrait
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request, array $args = [])
    {
<<<<<<< HEAD

        $vars = $request->get('variables');
        if($vars === null){
            $vars = [];
        }

        if($request->wantsJson() && count($vars) > 0){

            $query = $request->get('variables');
            $request->request->add([ $this->username() => $query['email'] ]);
            $request->request->add(['password' => $query['password']]);
            $request->request->remove('variables');
            $request->request->remove('query');        
		}else if($request->wantsJson()){
            $request->request->add([ $this->username() => $args['email']]);
            $request->request->add(['password' => $args['password']]);
        }
        
        $this->validateLogin($request);

       
=======
        return response()->json(["data"=> $request->all()]);
        if($request->has('token')){
            return $this->ajaxLogin($request);
        }

        $this->validateLogin($request);
        
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        
        if ($user = $this->attemptLogin($request)) {
            return $this->sendLoginResponse($request, $user);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);

    }

    public function ajaxLogin(Request $request)
    {

        if ($this->attemptAjaxLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);

    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {

        $request->validate([
<<<<<<< HEAD
           $this->username() => 'required|email|string',
           'password' => 'required|string|min:6'
=======
            $this->username() => 'required|string',
            'password' => 'required|string|min:6',
            'token' => 'string',
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
        ]);

    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $valid_user = false;
        $credentials =  $this->credentials($request);

        //Retrieve from Mysql Database
        $users = \App\User::where("EMAIL", $credentials['EMAIL'])->get();      

        foreach($users AS $record){ 
            if(\Hash::check($credentials['password'], $record->UPASS)){
                $valid_user = true;
                $user = $record;        
			}
		}

<<<<<<< HEAD
        //no valid user could be found in MYSQL database then chek dbf file and wil store in mysql if found
        if($valid_user !== true){
           $valid_user = User::createCredentialsFromPasswordsTable($credentials);
		}

        if($valid_user === true ){
=======
            if($credentials !== null && !$request->has("token") ){
                 \Session::put("credentials", $credentials->getAttributes());
            }
            return true;
        }else if(User::where('email',$credentials["email"])->first() === null){
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

            if($request->ajax()){

<<<<<<< HEAD
                if(!isset($user)){
                    $user = \App\User::where('EMAIL', $credentials['EMAIL'])->first();
                }
                return $user;
=======
            if ($createdUser !== false && $this->guard()->attempt($credentials, $request->filled('remember') ) && !$request->has("token") ) {
                \Session::put("credentials", $createdUser->getAttributes());
               return true;
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
            }

            $this->guard()->attempt($credentials, $request->filled('remember'));
            return $this->guard()->user();
           
        }

        return false;
    }

<<<<<<< HEAD
    /*
    {
    	"email":"kstark@centerpointlargeprint.com",
	"password":"madeleine01x"
    }

    {
	"email":"sgrjr@deliverance.me",
	"password":"1230happy"

}
    */
=======
    protected function attemptAjaxLogin(Request $request)
    {

        $credentials =  $this->credentials($request);

        if($this->guard()->attempt($credentials, $request->filled('remember')) ){
            $credentials = User::getCredentialsFromTable($credentials);

            return true;
        }else if(User::where('email',$credentials["email"])->first() === null){

            $createdUser = User::createCredentialsFromPasswordsTable($credentials);

            if ($createdUser !== false && $this->guard()->attempt($credentials, $request->filled('remember') ) && !$request->has("token") ) {
               return true;
            }

        }

        return false;
    }
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password'); 
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request, $user)
    {
<<<<<<< HEAD
        $this->clearLoginAttempts($request);

        if($request->wantsJson()){
            $this->authenticated($request, $user);
           return $user;
        }
        
        $request->session()->regenerate();
        
        return $this->authenticated($request, $user)
=======

        if($request->has("token")){

            return response()->json([
                'data' => [
                    "user" => $this->guard()->user(),

                    ]
                ]);

        }else{
            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            return $this->authenticated($request, $this->guard()->user())
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
                ?: redirect()->intended($this->redirectPath());
        }
        
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if($request->has("token")){
            return response()->json(["error"=>"Auth Failed"]);
        }else{
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }

    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'EMAIL';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        if($request->wantsJson()){
           // $this->loggedOut($request);
            return \App\Helpers\Application::props();
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

        /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
   protected function authenticated(Request $request, $user)
    {
        event(new UserLoggedIn($user));

        return true;
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        event(new \Illuminate\Auth\Events\Logout($request));
        return true;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        if(request()->ajax()){
            return Auth::guard();
		}else{
            return Auth::guard();
		}
       
    }


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
            'EMAIL' => $data['email'],
            'password' => $data['password']
        ]);
    }

}