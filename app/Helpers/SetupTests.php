<?php namespace App\Helpers;

use Rebing\GraphQL\GraphQLController;
use Illuminate\Support\Str;
use App\Helpers\StringHelper;
use Config, stdclass, Schema;
use App\Models\User, App\Models\OauthClient;

class Response{
    public function __construct(){
        $this->passed = $passed;
        $this->name = $name;
    }

    public static function make($passed, $name){
        $x = new stdclass;
        $x->passed = $passed;
        $x->name = $name;
        return $x;
    }
}
class SetupTests
{

    public function __construct(){
        $this->tests = [];
        $this->testNames = [
            "THERE_IS_A_USERS_TABLE",
            "USERS_TABLE_HAS_ENTRIES",
            "KEY_GENERATE_WAS_RUN",
            "OAUTH_CLIENT_EXISTS"
        ];
    }

    public function all(){
        foreach($this->testNames AS $tn){
            $func = StringHelper::camelCase($tn);
            $this->tests[] = Response::make($this->$func(), $tn );
        }

        return $this->tests;
    }

    public function test($name){
          $func = StringHelper::camelCase($name);
          return Response::make($this->$func(), $name);
    }

  public function thereIsAUsersTable(){
        return Schema::hasTable('users');
  }

  public function usersTableHasEntries(){
        return Schema::hasTable('users') && User::count() > 0;
  }

  public function keyGenerateWasRun(){
    return isset(Config::get('app')["key"]);
  }

  public function oauthClientExists(){
    return OauthClient::first() !== null;
  }

}

