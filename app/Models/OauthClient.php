<?php namespace App\Models;

use Carbon\Carbon;

class OauthClient extends BaseModel {
	protected $table = "oauth_clients";
	protected $seed = [];
	protected $fillable = ["id", "user_id", "name","secret", "provider", "redirect", "personal_access_client", "password_client", "revoked"];
}
