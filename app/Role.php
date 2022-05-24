<?php namespace App;

class Role extends BaseModel {

  protected $fillable = ['name'];
  protected $table = "roles";

	public function permissions()
    {
        return $this->belongsToMany('\App\Permission');
    }
	
}
