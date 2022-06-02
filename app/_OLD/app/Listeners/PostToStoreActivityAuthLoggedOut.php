<?php

namespace App\Listeners;

use \App\Events\GraphQLAuth\GraphQLUserLoggedOut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class PostToStoreActivityAuthLoggedOut
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
     * @param  \App\Events\GraphQLAuth\GraphQLUserLoggedOut $event
     * @return void
     */
    public function handle(GraphQLUserLoggedOut $event)
    {
        Log::channel('events')->info('User logged out: ' . $event->user->EMAIL);
    }
}
