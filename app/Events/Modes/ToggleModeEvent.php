<?php

namespace App\Events\Modes;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ToggleModeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $modeId;
    public $isActive;
    public $homeId;

    public function __construct($modeId, $isActive, $homeId)
    {
        $this->modeId = $modeId;
        $this->isActive = $isActive;
        $this->homeId = $homeId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('home.' . $this->homeId),
        ];
    }
    public function broadcastAs(): string
    {
        return 'toggle_mode';
    }
    public function broadcastWith(): array
    {
        return [
            'mode_id' => $this->modeId,
            'is_active' => $this->isActive,
        ];
    }
}
