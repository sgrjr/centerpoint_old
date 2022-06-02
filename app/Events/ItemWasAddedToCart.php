<?php

namespace App\Events;
use App\Models\Webdetail;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemWasAddedToCart implements ShouldBroadcastNow
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
    public function __construct(Webdetail $item, User $user)
    {
        $this->item = $item;
        $this->user = $user;
        $this->message = $item->TITLE . " (ISBN: " . $item->ISBN . ") was added to cart " . $item->REMOTEADDR;
    }

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
