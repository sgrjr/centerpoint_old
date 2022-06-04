<?php

namespace App\Listeners;

use App\Events\ItemWasAddedToCart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostToStoreActivityItemWasAddedToCart
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
     * @param  \App\Events\ItemWasAddedToCart  $event
     * @return void
     */
    public function handle(ItemWasAddedToCart $event)
    {
        //
    }
}
