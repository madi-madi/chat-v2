<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserSignedUp extends Event implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $room_name;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message , $room_name)
    {
        $this->message = $message;
        $this->room_name = $room_name;

        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
       // return new PrivateChannel('channel');
       // return ['room/'.$this->room_name];
        
  //     return new Channel ('room.'.$room_name->id);
         return ['Forsan'];
    }
}
