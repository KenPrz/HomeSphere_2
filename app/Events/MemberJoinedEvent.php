<?php

namespace App\Events;

use App\Http\Controllers\AppUtilities;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class MemberJoinedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $home_id;
    public $user_id;
    /**
     * Create a new event instance.
     */
    public function __construct($user_id,$home_id)
    {
        $this->user_id = $user_id;
        $this->home_id = $home_id;
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

    public function broadcastAs()
    {
        return 'member_joined';
    }

    public function broadcastWith()
    {
        $newHomeMember = DB::table('home_members')
        ->join('users', 'home_members.member_id', '=', 'users.id')
        ->select('users.id', 'users.firstName', 'users.lastName','users.profile_image', 'home_members.role', 'home_members.joined_on')
        ->where('home_members.member_id', $this->user_id)
        ->get();
        return [
            'new_member' => $newHomeMember
        ];
    }
}