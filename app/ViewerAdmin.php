<?php namespace App;

use \App\ViewerAdmin;

class ViewerAdmin {

    public function __construct()
    {
        $this->classes = [
            'allhead' => \App\Allhead::class,
            'alldetail' => \App\Alldetail::class,
            'ancienthead' => \App\Ancienthead::class,
            'ancientdetail' => \App\Ancientdetail::class,
            'backhead' => \App\Backhead::class,
            'backdetail' => \App\backdetail::class,
            'booktext' => \App\Booktext::class,
            'brohead' => \App\Brohead::class,
            'brodetail' => \App\Brodetail::class,
            'history' => \App\History::class,
            'inventory' => \App\Inventory::class,
            'password' => \App\Password::class,
            'standingorder' => \App\StandingOrder::class,
            'user' => \App\User::class,
            'vendor' => \App\Vendor::class,
            'webhead' => \App\Webhead::class,
            'webdetail' => \App\Webdetail::class
        ];

    }

    public function __get($name)
    {   
        $model = new $this->classes[$name];
        return new ViewerAdminModel($name, $model);
    }

}