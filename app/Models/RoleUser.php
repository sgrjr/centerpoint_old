<?php namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Traits\ManageTableTrait;
use App\Traits\ModelTrait;

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

   public function getIndexesAttribute(){
    return ["role_id","user_id"];
   }
}
