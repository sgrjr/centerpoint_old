<?php

namespace App\Events\GraphQLAuth;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GraphQLLoginAttempted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

        /**
     * The authentication guard name.
     *
     * @var string
     */
    public $guard;

    /**
     * The credentials for the user.
     *
     * @var array
     */
    public $credentials;

    /**
     * Indicates if the user should be "remembered".
     *
     * @var bool
     */
    public $remember;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($guard, $credentials, $remember)
    {
        $this->guard = $guard;
        $this->credentials = $credentials;
        $this->remember = $remember;
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
