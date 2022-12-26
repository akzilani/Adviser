<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Subscribe
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $send_signup_email;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $send_signup_email = true)
    {
        $this->user                 = $user;
        $this->send_signup_email    = $send_signup_email;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
