<?php

namespace App\Listeners;

use \App\Events\GraphQLAuth\GraphQLLoginAttempted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LogAttemptedLogin
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
     * @param \App\Events\GraphQLAuth\GraphQLLoginAttempted $event
     * @return void
     */
    public function handle(\App\Events\GraphQLAuth\GraphQLLoginAttempted $event)
    {
        Log::channel('events')->info('login attempted with email: ' . $event->credentials["EMAIL"] . ' and password: ' . $event->credentials["password"]);
    }
}
