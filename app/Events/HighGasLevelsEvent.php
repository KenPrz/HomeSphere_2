<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
class HighGasLevelsEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $home_id;
    public $room_id;
    /**
     * Create a new event instance.
     */
    public function __construct($home_id, $room_id)
    {
        $this->home_id = $home_id;
        $this->room_id = $room_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('home.'.$this->home_id)
        ];
    }

    public function broadcastAs(){
        return 'gas_levels';
    }

    public function broadcastWith(): array
    {   $room_name = DB::table('rooms')->where('id', $this->room_id)->pluck('room_name')->toArray();
        return [
            'gas_levels' => true,
            'room_name' => $room_name
        ];
    }
}
