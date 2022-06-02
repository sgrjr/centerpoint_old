<?php namespace App\Helpers;

use \App\Helpers\ViewerAdminModel;

class ViewerAdmin {

    public function __construct()
    {
        $this->classes = [
            'allhead' => \App\Models\Allhead::class,
            'alldetail' => \App\Models\Alldetail::class,
            'ancienthead' => \App\Models\Ancienthead::class,
            'ancientdetail' => \App\Models\Ancientdetail::class,
            'backhead' => \App\Models\BackHead::class,
            'backdetail' => \App\Models\backdetail::class,
            'booktext' => \App\Models\Booktext::class,
            'brohead' => \App\Models\BroHead::class,
            'brodetail' => \App\Models\BroDetail::class,
            'history' => \App\Models\History::class,
            'inventory' => \App\Models\Inventory::class,
            'standingorder' => \App\Models\StandingOrder::class,
            'user' => \App\Models\User::class,
            'vendor' => \App\Models\Vendor::class,
            'webhead' => \App\Models\Webhead::class,
            'webdetail' => \App\Models\WebDetail::class
        ];

    }

    public function __get($name)
    {   
        $model = new $this->classes[$name];
        return new ViewerAdminModel($name, $model);
    }

}