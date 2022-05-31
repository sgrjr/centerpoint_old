<?php

namespace App\Listeners;

use App\Events\GraphQLAuth\GraphQLLoginAttempted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class PostToStoreActivityAttemptedLogin
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
     * @param  \App\Events\GraphQLAuth\GraphQLLoginAttempted  $event
     * @return void
     */
    public function handle(GraphQLLoginAttempted $event)
    {
        Log::channel('events')->info('User attempting to log in: ' . $event->credentials['email']);
    }
}
