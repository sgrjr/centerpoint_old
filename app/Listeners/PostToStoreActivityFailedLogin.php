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
        $room_name = 'store_activity';
        $mssg = 'User FAILED to log in: ' . $event->credentials['email'] . " " . $event->reason;
        $user = \App\Models\User::where('id',1)->first();
        $room = \App\Models\Room::where("name","store_activity")->first();

        if($room === null){
            $room = new  \App\Models\Room(['name'=> $room_name]);
            $room->save();
        }

        Log::channel('events')->info($mssg);
       /*
        $message = $user->messages()->create([
            'message' => $mssg,
            'room_id' => $room->id
        ]);
        */
        //broadcast(new MessageSent($user, $room, $message))->now();
    }
}
