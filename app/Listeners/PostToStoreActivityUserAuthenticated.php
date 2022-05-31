<?php

namespace App\Listeners;

use App\Events\GraphQLAuth\GraphQLUserAuthenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class PostToStoreActivityUserAuthenticated {

    //use InteractsWithQueue;

    public $afterCommit = true;
    //public $tries = 3;

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
     * @param  \App\Events\GraphQLAuth\GraphQLUserAuthenticated  $event
     * @return void
     */
    public function handle(GraphQLUserAuthenticated $event)
    {
       Log::channel('events')->info('User logged in: ' . $event->user->EMAIL);
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\OrderShipped  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(GraphQLUserAuthenticated $event, $exception)
    {
        //
    }

    /**
     * Determine the time at which the listener should timeout.
     * use instead of setting public $tries (either/or)
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addMinutes(1);
    }
}