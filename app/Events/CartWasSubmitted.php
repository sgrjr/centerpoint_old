<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartWasSubmitted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $cart;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, \App\Models\WebHead $cart)
    {
        $this->cart = $cart;
        $this->user = $request->user();
    }

    /*
    By default, Laravel will broadcast the event using the event's class name. However, you may customize the broadcast name by defining a broadcastAs method on the event:
    */

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new Channel('store_activity');
    }
}