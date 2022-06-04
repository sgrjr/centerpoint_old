<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use \App\Models\User;

class ExistingDbfEntryUpdated implements ShouldBroadcastNow
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
    public function __construct($item, User $user)
    {
        $this->item = $item;
        $this->user = $user;
        $this->message = 'Existing ' . get_class($item) . ' entry was updated with id ' . $item->id . ' and INDEX ' . $item->INDEX;
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
