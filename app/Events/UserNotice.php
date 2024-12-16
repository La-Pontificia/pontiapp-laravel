<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotice implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $title;
    public $description;
    public $actions;

    public function __construct($userId, $title, $description, $actions)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->actions = $actions;
    }

    public function broadcastOn()
    {
        return new Channel("auth." . $this->userId);
    }

    public function broadcastAs()
    {
        return "notice";
    }

    public function broadcastWith()
    {
        return [
            "title" => $this->title,
            "description" => $this->description,
            "actions" => $this->actions,
        ];
    }
}
