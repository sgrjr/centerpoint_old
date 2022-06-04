<?php namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
 
class PersonalAccessToken extends SanctumPersonalAccessToken
{
   	protected $table = "personal_access_tokens";
	protected $seed = [];
	protected $fillable = ["id","client_id","tokenable_type","tokenable_id","name","token","abilities","last_used_at"];

	public function user(){
		return $this->belongsTo(\App\Models\User::static, );
	}
}