<?php namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Traits\ManageTableTrait;
use App\Models\Traits\ModelTrait;

class PermissionRole extends Pivot implements \App\Models\Interfaces\ModelInterface {

	use ManageTableTrait, ModelTrait;

  protected $fillable = ['permission_id','role_id'];
  protected $table = "permission_role";
  public $timestamps = false;

  protected $seed = [
    'config_permission_role'
  ];

protected $attributeTypes = [

        "role_id"=>[
            "name" => "role_id",
            "type" => "INT",
            "length" => 255
           ],
       "permission_id"=>[
            "name" => "permission_id",
            "type" => "INT",
            "length" => 255
           ]
      ];

   public function dbfSave(){
    return $this;
   }

   public function getIndexesAttribute(){
    return ["role_id","permission_id"];
   }
}
