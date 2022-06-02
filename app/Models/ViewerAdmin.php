<?php namespace App\Models;

use \App\Models\ViewerAdmin;

class ViewerAdmin {

    public function __construct()
    {
        $this->classes = [
            'allhead' => \App\Models\Allhead::class,
            'alldetail' => \App\Models\Alldetail::class,
            'ancienthead' => \App\Models\Ancienthead::class,
            'ancientdetail' => \App\Models\Ancientdetail::class,
            'backhead' => \App\Models\Backhead::class,
            'backdetail' => \App\Models\backdetail::class,
            'booktext' => \App\Models\Booktext::class,
            'brohead' => \App\Models\Brohead::class,
            'brodetail' => \App\Models\Brodetail::class,
            'history' => \App\Models\History::class,
            'inventory' => \App\Models\Inventory::class,
            'password' => \App\Models\Password::class,
            'standingorder' => \App\Models\StandingOrder::class,
            'user' => \App\Models\User::class,
            'vendor' => \App\Models\Vendor::class,
            'webhead' => \App\Models\Webhead::class,
            'webdetail' => \App\Models\Webdetail::class
        ];

    }

    public function __get($name)
    {   
        $model = new $this->classes[$name];
        return new ViewerAdminModel($name, $model);
    }

}