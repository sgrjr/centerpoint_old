<?php

namespace App\Listeners;

use App\Events\NewDbfEntryCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostToStoreActivityNewDbfEntryCreated
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
     * @param  \App\Events\NewDbfEntryCreated  $event
     * @return void
     */
    public function handle(NewDbfEntryCreated $event)
    {
        //
    }
}
