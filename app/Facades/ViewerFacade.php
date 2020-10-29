<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ViewerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'viewer';
    }
}