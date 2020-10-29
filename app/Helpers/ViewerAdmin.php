<?php namespace App\Helpers;

use \App\Helpers\ViewerAdminModel;

class ViewerAdmin {

    public function __construct()
    {
        $this->classes = [
            'allhead' => \App\AllHead::class,
            'alldetail' => \App\AllDetail::class,
            'ancienthead' => \App\AncientHead::class,
            'ancientdetail' => \App\AncientDetail::class,
            'backhead' => \App\BackHead::class,
            'backdetail' => \App\backdetail::class,
            'booktext' => \App\Booktext::class,
            'brohead' => \App\BroHead::class,
            'brodetail' => \App\BroDetail::class,
            'history' => \App\History::class,
            'inventory' => \App\Inventory::class,
            'standingorder' => \App\StandingOrder::class,
            'user' => \App\User::class,
            'vendor' => \App\Vendor::class,
            'webhead' => \App\WebHead::class,
            'webdetail' => \App\WebDetail::class
        ];

    }

    public function __get($name)
    {   
        $model = new $this->classes[$name];
        return new ViewerAdminModel($name, $model);
    }

}