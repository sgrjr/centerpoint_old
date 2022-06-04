<?php namespace App\Helpers;

use Auth;
use App\Models\User;
use App\Core\AuthenticatesUsersTrait;

class ViewerAuth {

    use AuthenticatesUsersTrait;

    public static function isAuthenticated(){
        if(request()->ajax()){
           return auth('api')->check();
        } else {
            return auth()->check();
        }

	}

    public static function getUser(){
        if(request()->ajax()){
            if(auth('api')->check()){
                return auth('api')->user();
			}
           return \App\Models\User::getGuest();
        } else{
            if(auth()->check()){
                return auth()->user();
			}
            return \App\Models\User::getGuest();
        }
        
    }

}