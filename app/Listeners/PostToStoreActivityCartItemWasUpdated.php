<?php

namespace App\Listeners;

use App\Events\CartItemWasUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostToStoreActivityCartItemWasUpdated
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
     * @param  \App\Events\CartItemWasUpdated  $event
     * @return void
     */
    public function handle(CartItemWasUpdated $event)
    {
        //
    }
}
