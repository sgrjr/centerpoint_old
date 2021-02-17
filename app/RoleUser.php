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

   public function dbfSave(){
    return $this;
   }
}
