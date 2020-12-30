<?php namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Core\ManageTableTrait;
use App\Core\ModelTrait;

class RoleUser extends Pivot implements \App\Interfaces\ModelInterface {

	use ManageTableTrait, ModelTrait;

  protected $fillable = ['role_id','user_id'];
  protected $table = "role_user";
  public $timestamps = false;

  protected $seed = [
    'config_role_user'
  ];

protected $attributeTypes = [

        "role_id"=>[
            "name" => "role_id",
            "type" => "INT",
            "length" => 255
           ],
       "user_id"=>[
            "name" => "user_id",
            "type" => "INT",
            "length" => 255
           ]
      ];
  public function schema($table){

    $table->unsignedInteger('role_id');
    $table->unsignedInteger('user_id');

    $table->foreign('user_id')->references('id')->on('users');
    $table->foreign('role_id')->references('id')->on('roles');
    
    return $table;
   }

   public function saveChanges(){
       $this->save();
       return $this;
   }
}
