<?php

namespace App\Events;
use App\Models\room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $room_id;
    public function __construct($room_id)
    {   
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
            new PrivateChannel('room.'.$this->room_id),
        ];
    }

    public function broadcastAs(){
        return 'sensor_update';
    }

    public function broadcastWith(): array
    {
        $sensorData = Room::with('tempSensor', 'humiditySensor', 'motionSensor')
        ->where('id', $this->room_id)
        ->get();
    

        return [
            'sensor_data' => $sensorData,
        ];
    }
}
/*
    $newRoomData = Room::with('devices', 'tempSensor', 'humiditySensor', 'motionSensor')
    ->where('id', $this->room_id)
    ->get();    
*/ 
