<?php namespace App;

use Carbon\Carbon;

class OauthAccessToken extends BaseModel {

	protected $table = "oauth_access_tokens";
	protected $seed = [];

	public static function getUser($token){
		return static::where('id', $token)->first();
	}
}
