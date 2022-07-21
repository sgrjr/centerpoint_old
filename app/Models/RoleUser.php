<?php namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Traits\ManageTableTrait;
use App\Models\Traits\ModelTrait;

class RoleUser extends Pivot implements \App\Models\Interfaces\ModelInterface {

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

    public $foreignKeys = [
        ["role_id","id","roles"], //rold_id references id on roles
        ["user_id","id","users"], //user_id references id on users
    ];

   public function dbfSave(){
    return $this;
   }

   public function getIndexesAttribute(){
    return ["role_id","user_id"];
   }
}