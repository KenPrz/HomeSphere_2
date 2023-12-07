<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room\EditRoomRequest;
use App\Models\Motion_sensor;
use App\Models\Room;
use App\Http\Controllers\AppUtilities;
use App\Http\Requests\Room\CreateRoomRequest;
use App\Models\Humidity_sensor;
use App\Models\Temp_sensor;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Home;
use App\Models\User;
use App\Notifications\RoomNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\NotificationHandler;
class RoomsController extends Controller
{   
    public $notificationHandler;
    public $homeInstance;
    public $appUtilities;
    public function __construct()
    {
        $this->notificationHandler = new NotificationHandler;
        $this->appUtilities = new AppUtilities;
        $this->homeInstance = new Home;
    }
    public function index()
    {
        $appUtilities = new AppUtilities;
        $user = auth()->user();
        $notifications = $this->notificationHandler->getNotifications($user);
        $homeData = $appUtilities->findHomeData($user);
        
        // Retrieve the rooms and their sensor data
        $roomData = Room::with('devices', 'tempSensor', 'humiditySensor', 'motionSensor')
            ->where('home_id', $homeData->id)
            ->select(['rooms.*'])
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM devices WHERE devices.room_id = rooms.id) as device_count'))
            ->get();
    
        return Inertia::render('Rooms/Main', [
            'notifications' => $notifications,
            'homeData' => $homeData,
            'rooms' => $roomData,
        ]);
    }

    public function addRoom(CreateRoomRequest $request)
    {   
        $validated = $request->validated();
        $user = auth()->user();
        $homeData = $this->appUtilities->findHomeData($user);
        $roomName = $validated['room_name'];
        $roomIcon = $validated['room_icon'];
        $this->createRoom($roomName,$roomIcon, $homeData->id, $user->id);
        return redirect()->back();
    }

    public function editRoom(EditRoomRequest $request)
    {   
        $validated = $request->validated();
        $appUtilities = new AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);
        
        DB::table('rooms')
            ->where('home_id', $homeData->id)
            ->where('id', $validated['room_id'])
            ->update(['room_name'=> $validated['roomName'], 'room_icon' => $validated['room_icon']]);
    }

    public function deleteRoom(Request $request)
    {   
        $request -> validate([
            'room_id' => 'required | integer'
        ]);
        $roomName = DB::table('rooms')->where('id', $request->room_id)->value('room_name');
        $user = auth()->user();
        $homeData = $this->appUtilities->findHomeData($user);
        $this->deleteRoomByID($request->room_id);
        $notificationData = [
            'title' => 'Room Deleted',
            'body'=> 'has deleted room: '. $roomName,
            'user' => $user->id,
            'type' => 'delete',
        ];
        $this->roomNotification($homeData->id,$notificationData);
    }
    private function createRoom($roomName, $roomIcon, $homeID, $roomOwnerID)
    {
        $room = Room::create([
            'room_name' => $roomName,
            'home_id' => $homeID,
            'room_owner_id' => $roomOwnerID,
            'room_icon' => $roomIcon,
            'created_at' => now(),
        ]);
        Temp_sensor::create([
            'room_id' => $room->id,
            'temperature' => null,
        ]);
    
        Humidity_sensor::create([
            'room_id' => $room->id,
            'humidity' => null,
        ]);
        Motion_sensor::create([
            'room_id' => $room->id,
            'is_active' => false,
            'motion_detected' => false
        ]);
        $user = auth()->user();
        $notificationData = [
            'title' => 'New Room Created',
            'body'=> 'has created a new room',
            'user' => $user->id,
            'type' => 'create',
        ];
        $this->roomNotification($homeID,$notificationData);
    }
    private function deleteRoomByID($roomID)
    {
        DB::table('rooms')->where('id', $roomID)->delete();
    }
    private function roomNotification($home_id,$notificationData)
    {
        $home = Home::find($home_id);
        $members = $home->members->where('role', '!=', 'pending')->where('member_id', '!=', auth()->user()->id);
        foreach ($members as $member) {
            $user = User::find($member->member_id);
            $user->notify(new RoomNotification($notificationData));
        }
    }
}