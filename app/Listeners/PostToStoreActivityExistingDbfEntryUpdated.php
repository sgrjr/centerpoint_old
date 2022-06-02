<?php

namespace App\Listeners;

use App\Events\ExistingDbfEntryUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostToStoreActivityExistingDbfEntryUpdated
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
     * @param  \App\Events\ExistingDbfEntryUpdated  $event
     * @return void
     */
    public function handle(ExistingDbfEntryUpdated $event)
    {
        //
    }
}
