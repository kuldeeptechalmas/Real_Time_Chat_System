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

class ViewToReceiver implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $users_data;
    public function __construct($users_data)
    {
        $this->users_data = $users_data;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('receive-channel'),
        ];
    }
    public function broadcastAs()
    {
        return 'receive-event';
    }
}
