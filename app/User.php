<?php namespace App;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Schema\Blueprint;
use Carbon, Session, Mail, Config;

use App\Viewer;
use Illuminate\Support\Collection;
use Auth, Event, Schema, stdClass;
use Request;

////////////////////////////////////////////

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Core\PresentableTrait;
use Illuminate\Support\Str;

class User extends Authenticatable
{

	use PresentableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','key','name','email','verified','role', 'password','remember_token','nickname','confirmation_code','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	protected $appends = ['fullname','token','authenticated','tableSafeName','source'];
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $presenter = 'App\Presenters\UserPresenter';

    /**
     * Passwords must always be encrypted.
     *
     * @param $password
     */

    public function setPassword($password)
    {
    	return $this->attributes['password'] = bcrypt($password);
    }

public function ancientTitles(){return $this->hasMany('\App\AncientDetail', 'KEY', 'key');}
public function allTitles(){return $this->hasMany('\App\AllDetail', 'KEY', 'key');}
public function broTitles(){return $this->hasMany('\App\BroDetail', 'KEY', 'key');}
public function backTitles(){return $this->hasMany('\App\BackDetail', 'KEY', 'key');}

  public static function failLogin(){
            $auth = new stdClass;
            $auth->error = new stdClass;
            $auth->error->code = 200;
            $auth->error->message = "Session destroyed successfully";
            $auth->token = null;
            $auth->user = new User;
            return $auth;
  }

  public function orders()
    {
      return $this->hasMany('\App\Order', 'KEY', 'key');
    }

    public function titles()
    {
      return $this->hasMany(
            'App\OrderItem', 'KEY','key'
          );
    }
 
  public static function updateProfile($firstname,$middlename,$lastname,$suffix,$gender,$profile_image,$location)
  {

  	$user = \Auth::user();

  	$user->username = strtolower($firstname).'-'.strtolower($middlename).'-'.strtolower($lastname).strtolower($suffix);
  	$user->firstname = $firstname;
  	$user->middlename = $middlename;
  	$user->lastname = $lastname;
  	$user->suffix = $suffix;
  	$user->gender = $gender;

  	if($profile_image !== null){
  		$user->profile_image = $profile_image;
  	}

  	$user->location = $location;

  	return $user;
  }

    /**
     * Determine if the given user is the same
     * as the current one.
     *
     * @param  $user
     * @return bool
     */
    public function is($user)
    {
        if (is_null($user)) return false;

        return $this->username == $user->username;
    }

    public function isSetup()
    {
    	if ($this->username !== null) return true;

    	return false;
    }

    public function isConfirmed()
    {
    	if ($this->confirmed > 0) return true;

    	return false;
    }

    public function getAuthenticatedAttribute()
    {

      if(!\Schema::hasTable('users')){
        return false;
      }else if(Request::input('api_token') !== null){
          return Request::input('api_token') === $this->api_token;
      }else {
        return Auth::check();
      }
      
      
    }

	public function joined()
    {
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
    }



	public function getFullnameAttribute()
    {
        return $this->firstname.' '.$this->middlename.' '.$this->lastname.' '.$this->suffix;
    }

    public function getPhotoAttribute()
    {
        return '/img/profile-photo/'.base64_encode($this->key.$this->email);
    }

    public function passwordReset()
    {
    	$fromDate = \Carbon::now()->subDays(3);
    	$tillDate = \Carbon::now();

    	return $this->hasMany('\App\PasswordReset')
    		->whereBetween('created_at', [$fromDate, $tillDate])->first();
    }	

    public function getTokenAttribute(){

    	if($this->id == null){
              return null;
    	}else {
    	  return $this->api_token;
    	}

    }

	public static function getGuest($error = null)
	{
	   $guest = new User;
	   $guest->id = null;
	   $guest->email = null;
	   $guest->name = null;
	   $guest->password = null;
	   $guest->api_token = null;
     $guest->key = false;
     $guest->authenticated = false;
	   return $guest;

	}

public static function createCredentialsFromPasswordsTable($credentialsFromLogin){

    if(\Schema::hasTable("passwords")){
           $pass = \App\Password::where("email",$credentialsFromLogin["email"])
           ->where("upass",$credentialsFromLogin["password"])
            ->first();
    }else{
        $pass = null;
    }

    if($pass === null){

      $credentials = static::getCredentialsFromTable($credentialsFromLogin); 

        if($credentials !== null){
          $pass = $credentials;
        }

    }

    if($pass !== null){
      $user = static::makeUser([
        "key"=>$pass->key, "uname"=>$pass->uname, "email"=>$pass->email, "upass"=>$pass->upass
      ]);
      return $pass;
    }else{
      return false;
    }

}

public static function getCredentialsFromTable($credentialsFromLogin){

      //mpogorze@nileslibrary.org
      //niktech2015      
      //CREDENTIALS FOR AUTHORIZED USER

      $credentials = \App\Password::ask()
        ->setPerPage(1)
        ->where("UPASS","===", $credentialsFromLogin["password"])
        ->where("EMAIL","===", $credentialsFromLogin["email"])
        ->first();

      return $credentials;

}

public function createTable(){
   Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->string('key');
      $table->string('name');
      $table->string('email')->unique();
      $table->string('password');
      $table->string('api_token', 80)->unique()->nullable()->default(null);
      $table->rememberToken();
      $table->timestamps();
    });

  }

public function getMemo(){
        $config = Config::get("cp");
        $tablename = $this->getTable();
        return $config["tables"][$tablename]["memo"];
}

    public function getTableSafeNameAttribute(){
       return $this->getTable();
    }

        public function getSourceAttribute(){
        return strpos(strtolower($this->getTable()), ".dbf")? "DBF":"SEED";
    }

        public function getCount(){

        $x = new \stdclass;
        $x->mysql = $this->count();
        $x->dbf = false;
        return $x;
    }

        public function getTableExistsAttribute(){
        return \Schema::hasTable($this->tableSafeName);
    }

    public function manager(){
       return \App\TableManager::load($this);
    }

    public function getAlternateUpass(){
      return 'password';
    }

    public function getAlternateUname(){
      return 'name';
    }

    public function getSeed(){
        return $this->seed;
    }

    public function isFromDbf(){
        return strpos(strtolower($this->getSeed()), ".dbf") !== false;
    }

    public function getCredentialsAttribute(){
       $creds = \App\Password::ask()
        ->where("KEY","===", $this->present()->key)
        ->where("EMAIL","===", $this->email)
        ->first();

        if($creds === null){
          $creds = \App\Password::makeFromUser($this);
        }

        return $creds;
    }

      public function getRemoteAddr(){

        $remoteaddr = \Session::get('use_cart');

        if($remoteaddr === null){

          $webhead = (new \App\Webhead)->ask()
            ->where("KEY","===", $this->key )
            ->where("ISCOMPLETE","!=", "1" )
            ->get();

          if($webhead->paginator->count > 0){
            $cart = $webhead->records[$webhead->paginator->count-1];
            $remoteaddr = $cart->remoteaddr;
            Session::put("use_cart", $remoteaddr);
          }else{
              $newCart = \App\Webhead::newCart($this->key);
              $remoteaddr = $newCart->remoteaddr;
          }
          
        }

        return $remoteaddr;

    }

    public static function makeUser($attributes){

      $user = new static();

      foreach($attributes AS $key => $val){

        switch($key){

          case "upass":
          case "UPASS":
          case "PASSWORD":
          case "password":
            $user->setPassword($val);
            break;


          case 'uname':
            $user->name = $val;
            break;

          case 'EMAIL':
          case 'email':
            $user->email = $val;
            break;

          case 'key':
          case 'KEY':
            $user->key = $val;
            break;

          case 'token':
          case 'api_token':
                $user->api_token = $val;
                break;

          default:
            $user->$key = $val;

        }

      }
      
      $user->api_token = Str::random(60);

      $user->save();

      return $user;
    }

    public function updateProfilePhoto($file){
        
        //File Name
        //$file->getClientOriginalName();

        //File Extension
        //$file->getClientOriginalExtension();
     
        //Display File Real Path
       //$file->getRealPath();
     
        //Display File Size
        //$file->getSize();
     
        //Display File Mime Type
        //$file->getMimeType();
     
        //Move Uploaded File
        $destinationPath = storage_path() . '/uploads';
        $filename = base64_encode($this->key . $this->email) . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath,$filename);
        return $this;
    }

    public function getIsCustomerAttribute(){

      $hasCpEmail = strpos($this->email, "centerpointlargeprint");
      $isSuper = strpos($this->email, "deliverance.me");
  
      if($hasCpEmail !== false || $isSuper  !== false) {
        return false; 
       } else {
          return true;
        }
      
    }

    public function getPasswords()
    {
        return \App\Password::graphqlAsk()
            ->where("KEY","==",$this->key)
            ->where("EMAIL","==", $this->email)
            ->get()->records;
    }
  
    public function getVendorAttribute(){
        if($this->email == "sgrjr@deliverance.me"){
          $vendor = new \App\Vendor;
          $vendor->KEY = $this->key;
          $vendor->ORGNAME = "FAKE COMPANY";
          return $vendor;
      }else{
          return \App\Vendor::ask()
          ->where("KEY","===", $this->key)
          ->first();
      }
    }

  public function roles()
  {
    return $this->belongsToMany('\App\Role');
  }

    public function permissions()
    {
      $permissions = [];

      foreach($this->roles AS $role){

          foreach($role->permissions AS $p){
              $permissions[$p->name] = $p->name;
          }
      }

      return $permissions;
    }

    public function hasRole($role)
    {
       If ($this->roles()->where('name','=',$role)->first()) return true;

       return false;
    }
}