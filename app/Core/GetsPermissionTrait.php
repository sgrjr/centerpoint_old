<?php namespace App\Core;

use App\Helpers\PermissionRequested;

Trait GetsPermissionTrait
{

    public function can($request, $options = false)
    {
      $response = new PermissionRequested($this, $request, $options);
      return $response->can;
    }

    public function isSuperAdmin(){
    	return $this->EMAIL === "sgrjr@deliverance.me";
    }

}
