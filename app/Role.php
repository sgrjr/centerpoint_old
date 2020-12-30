<?php namespace App;

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

  public function schema($table){
    $table->string('name');
    return $table;
   }

	public function permissions()
    {
        return $this->belongsToMany('\App\Permission');
    }

    public function users(){
        return $this->belongsToMany('App\User')->using('App\RoleUser');
	}
   
	
}
