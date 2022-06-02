<?php

namespace App\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\User;

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
    public function login(Request $request)
    {
        return response()->json(["data"=> $request->all()]);
        if($request->has('token')){
            return $this->ajaxLogin($request);
        }

        $this->validateLogin($request);
        
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
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
            $this->username() => 'required|string',
            'password' => 'required|string|min:6',
            'token' => 'string',
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

        $credentials =  $this->credentials($request);

        if($this->guard()->attempt($credentials, $request->filled('remember')) ){

            $credentials = User::getCredentialsFromTable($credentials);

            if($credentials !== null && !$request->has("token") ){
                 \Session::put("credentials", $credentials->getAttributes());
            }
            return true;
        }else if(User::where('email',$credentials["email"])->first() === null){

            $createdUser = User::createCredentialsFromPasswordsTable($credentials);

            if ($createdUser !== false && $this->guard()->attempt($credentials, $request->filled('remember') ) && !$request->has("token") ) {
                \Session::put("credentials", $createdUser->getAttributes());
               return true;
            }

        }

        return false;
    }

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
    protected function sendLoginResponse(Request $request)
    {

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
                ?: redirect()->intended($this->redirectPath());
        }
        
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
        //
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
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
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
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}
