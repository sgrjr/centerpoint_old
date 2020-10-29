<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Storage;

class UserAlwaysHasACart
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $message = 'User Always Has a Cart ' . $event->user->id;
        Storage::put('loginactivity.txt', $message);

        if($event->user !== null && $user->vendor->cartsCount <= 0){
            \App\WebHead::newCart($viewer->user->vendor);
        }

    }
}
