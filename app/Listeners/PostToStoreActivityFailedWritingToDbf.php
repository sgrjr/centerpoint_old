<?php

namespace App\Listeners;

use App\Events\FailedWritingToDbf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostToStoreActivityFailedWritingToDbf
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
     * @param  \App\Events\FailedWritingToDbf  $event
     * @return void
     */
    public function handle(FailedWritingToDbf $event)
    {
        //
    }
}
