<?php namespace App\Models;

class Role extends BaseModel implements \App\Interfaces\ModelInterface {

      public $timestamps = false;
      protected $fillable = ['name'];
  
      protected $table = "roles";

      protected $seed = [
        'config_roles'
      ];

    protected $attributeTypes = [
        "name"=>[
            "name" => "name",
            "type" => "Char",
            "length" => 128
           ]
      ];

    protected $indexes = [];

	public function permissions()
    {
        return $this->belongsToMany('\App\Permission');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User')->using('App\Models\RoleUser');
	}
   
	
}
