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

    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Database\Eloquent\Collection $tickets
     */
    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        // Usamos el canal público o privado según las necesidades
        return new Channel('tickets');
    }

    /**
     * El nombre del evento que será escuchado por el cliente.
     */
    public function broadcastAs()
    {
        return 'ticketListUpdated';
    }

    /**
     * La data que será enviada al cliente WebSocket.
     */
    public function broadcastWith()
    {
        return [
            'tickets' => $this->tickets->toArray(),
        ];
    }
}
