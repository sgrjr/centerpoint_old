<?php namespace App;


use Carbon, Session, Config, Request, Auth, Event, Schema, stdClass;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Ask\AskTrait\AskTrait;
use App\Core\ModelTrait;
use App\Core\ManageTableTrait;
use App\Core\PresentableTrait;

use \App\Core\DbfTableTrait;
use App\Core\GetsPermissionTrait;

class User extends Authenticatable implements \App\Interfaces\ModelInterface, \Illuminate\Contracts\Auth\CanResetPassword {

  use AskTrait, ManageTableTrait, ModelTrait, PresentableTrait, CanResetPassword, DbfTableTrait, HasApiTokens, GetsPermissionTrait;

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
	

	protected $appends = [];
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $presenter = 'App\Presenters\UserPresenter';

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

    /**
     * Passwords must always be encrypted.
     *
     * @param $password
     */

    /*
    
    */


    public function setUpassAttribute($pass){
       $this->attributes['UPASS'] = \Hash::make($pass);
    }

  /*
    Mutators END
  */

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

  public function getIsbns()
    {
      return $this->hasMany('\App\Alldetail', 'KEY', 'KEY')->get(['PROD_NO'])->toArray();
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

        return '/img/profile-photo/'.base64_encode($this->KEY.$this->EMAIL);
    }

    public function passwordReset()
    {
    	$fromDate = \Carbon::now()->subDays(3);
    	$tillDate = \Carbon::now();

    	return $this->hasMany('App\Helpers\PasswordReset')
    		->whereBetween('created_at', [$fromDate, $tillDate])->first();
    }	


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

  public function roles()
  {
    return $this->belongsToMany('App\Role')->using('App\RoleUser');
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


    public function getTokenAttribute(){
      return $this->createToken("authToken")->accessToken;
    }

      public function getRemoteAddr(){

        $remoteaddr = Session::get('use_cart');

        if($remoteaddr === null){

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
    public function getIsCustomerAttribute(){


      $hasCpEmail = strpos($this->EMAIL, "centerpointlargeprint");
      $isSuper = strpos($this->EMAIL, "deliverance.me");
  
      if($hasCpEmail !== false || $isSuper  !== false) {
        return false; 
       } else {
          return true;
        }
      
    }

        public function updateProfilePhoto($_, $args){
        
        $user = request()->user();
        $file = $args['profilePicture'];
        

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
        $filename = base64_encode($user->KEY . $user->EMAIL) . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath,$filename);
        return $user;
    }

    public function getPasswords()
    {
        return \App\Password::graphqlAsk()
            ->where("KEY","==",$this->key)
            ->where("EMAIL","==", $this->email)
            ->get()->records;
    }

    
}