<?php

namespace App\Listeners;

use \App\Events\GraphQLAuth\GraphQLUserAuthenticationFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;
use \App\Models\Message;
use \App\Events\MessageSent;

class PostToStoreActivityFailedLogin
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
     * @param  \App\Events\GraphQLAuth\GraphQLUserAuthenticationFailed  $event
     * @return void
     */
    public function handle(GraphQLUserAuthenticationFailed $event)
    {
        $mssg = 'User FAILED to log in: ' . $event->credentials['EMAIL'] . " " . $event->reason;
        $user = \App\Models\User::where('id',1)->first();

        Log::channel('events')->info($mssg);
        $message = $user->messages()->create([
            'message' => $mssg
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();
    }
}
