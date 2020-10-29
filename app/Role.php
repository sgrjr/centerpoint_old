<?php namespace App;

class Role extends BaseModel implements \App\Interfaces\ModelInterface {

<<<<<<< HEAD
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
=======
  protected $fillable = ['name'];
  protected $table = "roles";
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

	public function permissions()
    {
        return $this->belongsToMany('\App\Permission');
    }

    public function users(){
        return $this->belongsToMany('App\User')->using('App\RoleUser');
	}
   
	
}
