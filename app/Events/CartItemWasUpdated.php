<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartItemWasUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The Title instance added to the cart
     * 
     * 
     * @var \App\Models\Title;
    */

    public $item;
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Title $item;
     * @param \App\Models\User $user;
     * @return void
     */
    public function __construct(Title $item, User $user)
    {
        $this->item = $item;
        $this->user = $user;
        $this->message = $item->TITLE . " (ISBN: " . $item->ISBN . ") was was updated on cart " . $item->REMOTEADDR;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new InteractsWithSockets('store-activity');
    }
}
