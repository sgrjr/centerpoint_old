<?php

use Illuminate\Database\Seeder;
use App\Table;
use App\DatabaseManager;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        \App\User::seedTable();
=======
    	$config = Config::get("cp");
    	//truncate database
    	$this->emptyDB($config["dbname"]);
    	
		// users
		$us = $config["users"];
		$users = [];
		
		foreach($us AS $u){
			$u["password"] = \Hash::make($u["password"]);
            $u["api_token"] = Str::random(60);
			$users[] = $u;
		}

        DB::table('users')->insert($users);
		
		// roles
		$rs = $config["roles"];
		$roles = [];
		
		foreach($rs AS $r){
			$roles[] = ["name"=>$r];
		}
        DB::table('roles')->insert($roles);
		
		// role_user
		$role_user = [["user_id"=>1, "role_id"=>1]];
        DB::table('role_user')->insert($role_user);

}

public function emptyDB($db_name){
	
	Eloquent::unguard();

    // Truncate all tables, except migrations
    $tables = DB::select('SHOW TABLES');
    $prop = "Tables_in_".$db_name;
    foreach ($tables as $table) {
        if ($table->$prop!== 'migrations'){
            DB::table($table->$prop)->truncate();
        }
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
    }

}
