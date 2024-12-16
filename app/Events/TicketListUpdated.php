<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketListUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tickets;


    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function broadcastOn()
    {
        return new Channel('tickets');
    }


    public function broadcastAs()
    {
        return 'ticketListUpdated';
    }


    public function broadcastWith()
    {
        return [
            'tickets' => $this->tickets,
        ];
    }
}
