<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class ClearSessionAfterUserLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
       \Session::flush();
    }
}