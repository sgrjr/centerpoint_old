<?php namespace App;

<<<<<<< HEAD
use Carbon, Session, Config, Request, Auth, Event, Schema, stdClass;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Passwords\CanResetPassword;
=======
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
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Ask\AskTrait\AskTrait;
use App\Core\ModelTrait;
use App\Core\ManageTableTrait;
use App\Core\PresentableTrait;
<<<<<<< HEAD
use \App\Core\DbfTableTrait;
use App\Core\GetsPermissionTrait;

class User extends Authenticatable implements \App\Interfaces\ModelInterface, \Illuminate\Contracts\Auth\CanResetPassword {

  use AskTrait, ManageTableTrait, ModelTrait, PresentableTrait, CanResetPassword, DbfTableTrait, HasApiTokens, GetsPermissionTrait;

=======
use Illuminate\Support\Str;

class User extends Authenticatable
{

	use PresentableTrait;
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
<<<<<<< HEAD

    protected $fillable = ["INDEX","KEY","LOGINS","DATEUPDATE","DATESTAMP","UPASS","MPASS","UNAME","SNAME","EMAIL","PIC","COMPANY","SEX","FIRST","MIDNAME","LAST","ARTICLE","TITLE","ORGNAME","STREET","SECONDARY","CITY","CARTICLE","STATE","COUNTRY","POSTCODE","NATURE","VOICEPHONE","EXTENSION","FAXPHONE","COMMCODE","MDEPT","MFNAME","TSIGNOFF","TIMESTAMP","TIMEUPDATE","CANBILL","TAXEXEMPT","PASSCHANGE","PRINTQUE","SENDEMCONF","SEARCHBY","MULTIBUY","SORTBY","FULLVIEW","SKIPBOUGHT","OUTOFPRINT","OPROCESS","OBEST","OADDTL","OVIEW","ORHIST","OINVO","EXTZN","INSOS","INREG","LINVO","NOEMAILS","ADVERTISE","PROMOTION","PASSDATE","EMCHANGE",'remember_token'];
=======
    protected $fillable = [
        'id','key','name','email','verified','role', 'password','remember_token','nickname','confirmation_code','api_token'
    ];
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
        protected $hidden = [
            'remember_token'
        ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
	
<<<<<<< HEAD
	protected $appends = [];
=======
	protected $appends = ['fullname','token','authenticated','tableSafeName','source'];
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $presenter = 'App\Presenters\UserPresenter';
<<<<<<< HEAD
    protected $dbfPrimaryKey = 'INDEX';

      protected $seed = [
        'config_users',
        'dbf_users'
      ];

      protected $attributeTypes = [
        'remember_token'=>[
            'name' => 'remember_token',
            'type' => 'Char',
            'length' => 128
           ],
       'timestamps'=> true
      ];

    protected $casts = [
        'DATESTAMP' => 'date',
    ];

	public function getNameAttribute(){
       return $this->exists? $this->FIRST . " " . $this->LAST : null;
    }

    public function getApplicationAttribute(){
      return \App\Helpers\Application::props($this);
    }
=======
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

    /**
     * Passwords must always be encrypted.
     *
     * @param $password
     */

    /*
    
    */

<<<<<<< HEAD
    public function setUpassAttribute($pass){
       $this->attributes['UPASS'] = \Hash::make($pass);
    }


  /*
    Mutators END
  */

=======
public function ancientTitles(){return $this->hasMany('\App\AncientDetail', 'KEY', 'key');}
public function allTitles(){return $this->hasMany('\App\AllDetail', 'KEY', 'key');}
public function broTitles(){return $this->hasMany('\App\BroDetail', 'KEY', 'key');}
public function backTitles(){return $this->hasMany('\App\BackDetail', 'KEY', 'key');}
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

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
      return $this->hasMany('\App\Order', 'KEY', 'KEY');
    }

    public function titles()
    {
      return $this->hasMany('App\OrderItem', 'KEY','KEY');
    }
 
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'KEY','KEY');
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

    public function getPhotoAttribute()
    {
<<<<<<< HEAD
        return '/img/profile-photo/'.base64_encode($this->KEY.$this->EMAIL);
=======
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
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
    }

    public function getPhotoAttribute()
    {
        return '/img/profile-photo/'.base64_encode($this->key.$this->email);
    }

    public function passwordReset()
    {
    	$fromDate = \Carbon::now()->subDays(3);
    	$tillDate = \Carbon::now();

    	return $this->hasMany('App\Helpers\PasswordReset')
    		->whereBetween('created_at', [$fromDate, $tillDate])->first();
    }	

<<<<<<< HEAD
	public static function getGuest()
	{
	   $guest = new User;	   
       return $guest;

	}

  public function userSchema($table){
		$table->foreign('KEY')->references('KEY')->on('vendors');
        $table->string('api_token')->unique()->nullable()->default(null);
        $table->string("remember_token")->nullable();
        $table->timestamps();

		return $table;
	}

public function getMemo(){
        $config = Config::get("cp");
        $tablename = $this->getTable();
        return $config["tables"][$tablename][2];
}
=======
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
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

    public function getCount(){

        $x = new \stdclass;
        $x->mysql = $this->count();
        $x->dbf = false;
        return $x;
    }

        public function getTableExistsAttribute(){
            return \Schema::hasTable($this->getTable());
        }

    public function getAlternateUname(){
      return 'name';
    }

<<<<<<< HEAD
      public function getRemoteAddr(){

        $remoteaddr = Session::get('use_cart');

        if($remoteaddr === null){
=======
    if($pass !== null){
      $user = static::makeUser([
        "key"=>$pass->key, "uname"=>$pass->uname, "email"=>$pass->email, "upass"=>$pass->upass
      ]);
      return $pass;
    }else{
      return false;
    }
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

          $webhead = (new \App\WebHead)->ask()
            ->where("KEY","===", $this->KEY )
            ->where("ISCOMPLETE","!=", "1" )
            ->get();

          if($webhead->paginator->count > 0){
            $cart = $webhead->records[$webhead->paginator->count-1];
            $remoteaddr = $cart->remoteaddr;
            Session::put("use_cart", $remoteaddr);
          }else{
              $newCart = \App\WebHead::newCart($this->KEY);
              $remoteaddr = $newCart->remoteaddr;
          }
          
        }

        return $remoteaddr;

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
        $filename = base64_encode($this->KEY . $this->EMAIL) . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath,$filename);
        return $this;
    }

    public function getIsCustomerAttribute(){

<<<<<<< HEAD
      $hasCpEmail = strpos($this->EMAIL, "centerpointlargeprint");
      $isSuper = strpos($this->EMAIL, "deliverance.me");
  
      if($hasCpEmail !== false || $isSuper  !== false) {
        return false; 
       } else {
          return true;
        }
      
    }

  public function roles()
  {
    return $this->belongsToMany('App\Role')->using('App\RoleUser');
  }

    public function permissions()
    {
      $permissions = [];
=======
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
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

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

    public static function createCredentialsFromPasswordsTable($credentials){
        
       $email = isset($credentials["EMAIL"])? $credentials["EMAIL"]:$credentials["email"];
       $password = isset($credentials["UPASS"])? $credentials["UPASS"]:$credentials["password"];

      $user = \App\User::dbf()
              ->where("EMAIL","===", $email)
              ->where("UPASS","===", $password)
              ->first();
             
      if($user === null){

        $conf = \Config::get('cp');

        foreach($conf['users'] AS $u){
          if($u['EMAIL'] === $email && $u['UPASS'] === $password){
            $user = static::create($u);
            break;
          }else{
            $user = false;
          }
        }
        return $user;
      }else{
        $user->password = $user->UPASS;
        $user->save();
      }

      return $user? true:false;

    }

    public function getAuthPassword() {
       return $this->UPASS;
    }

<<<<<<< HEAD
    public function getTokenAttribute(){
      return $this->createToken("authToken")->accessToken;
=======
    public function getCredentialsAttribute(){
       $creds = \App\Password::ask()
        ->where("KEY","===", $this->present()->key)
        ->where("EMAIL","===", $this->email)
        ->first();

        if($creds === null){
          $creds = \App\Password::makeFromUser($this);
        }

        return $creds;
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
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