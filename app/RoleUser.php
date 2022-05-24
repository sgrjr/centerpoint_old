<?php namespace App;

class RoleUser extends BaseModel {

  protected $fillable = ['role_id','user_id'];
  protected $table = "role_user";
}
