<?php

namespace App\Listeners;

use App\Events\ItemWasAddedToCart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostToStoreActivity implements ShouldQueue
{

    use InteractsWithQueue;
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
     * @param  \App\Events\ItemWasAddedToCart  $event
     * @return void
     */
    public function handle(ItemWasAddedToCart $event)
    {
        //
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\OrderShipped  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(OrderShipped $event, $exception)
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
