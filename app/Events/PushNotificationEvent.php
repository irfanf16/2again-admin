<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushNotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;

    public $body;

    public $data;

    public $token;

    public $event;

    /**
     * Create a new event instance.
     *
     * @return void
     */


    public function __construct($title, $body, $data, $token, $event)
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
        $this->token = $token;
        $this->event = $event;
    }

   /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('message');
    }

    public function broadcastAs(){
        return $this->event;
    }
}
