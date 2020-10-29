<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomFacadesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       app()->bind('viewer', function(){
            return new \App\Helpers\Viewer;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}