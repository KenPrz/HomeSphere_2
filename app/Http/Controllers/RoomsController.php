<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room\EditRoomRequest;
use App\Models\motion_sensor;
use App\Models\room;
use App\Http\Controllers\AppUtilities;
use App\Http\Requests\Room\CreateRoomRequest;
use App\Models\humidity_sensor;
use App\Models\temp_sensor;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Home;
use App\Models\User;
use App\Notifications\RoomCreated;
use Illuminate\Support\Facades\Notification;
class RoomsController extends Controller
{   
    public $homeInstance;
    public function __construct()
    {
        $this->homeInstance = new home;
    }
    public function index()
    {
        $appUtilities = new AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);
        
        // Retrieve the rooms and their sensor data
        $roomData = Room::with('devices', 'tempSensor', 'humiditySensor', 'motionSensor')
            ->where('home_id', $homeData->id)
            ->select(['rooms.*'])
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM devices WHERE devices.room_id = rooms.id) as device_count'))
            ->get();
    
        return Inertia::render('Rooms/Main', [
            'notifications' => $user->notifications,
            'homeData' => $homeData,
            'rooms' => $roomData,
        ]);
    }

    public function addRoom(CreateRoomRequest $request)
    {   
        $validated = $request->validated();
        $appUtilities = new AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);

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
        $roomID = $request->input('room_id');
        $this->deleteRoomByID($roomID);
    }

    public function openRoom($roomID)
    {
        $roomData = $this->getRoomByID($roomID);
        $deviceData = $this->getDevicesInRoom($roomID);

        return Inertia::render('Rooms/Room', [
            'activeComponent' => 'Room ' . $roomData->id,
            'room' => $roomData,
            'devices' => $deviceData,
        ]);
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
        temp_sensor::create([
            'room_id' => $room->id,
            'temperature' => null,
        ]);
    
        humidity_sensor::create([
            'room_id' => $room->id,
            'humidity' => null,
        ]);
        motion_sensor::create([
            'room_id' => $room->id,
            'is_active' => false,
            'motion_detected' => false
        ]);
        $user = auth()->user();
        $userName = $user->firstName . ' ' . $user->lastName;
        $userProfile = $user->profile_image;
        $notificationData = [
            'title' => 'New Room Created',
            'body'=> 'has created a new room',
            'user_name' => $userName,
            'icon' => $userProfile,
        ];
        $this->newRoomNotification($homeID,$notificationData);
    }

    private function deleteRoomByID($roomID)
    {
        DB::table('rooms')->where('id', $roomID)->delete();
    }

    private function getRoomByID($roomID)
    {
        return DB::table('rooms')->where('id', $roomID)->first();
    }

    private function getDevicesInRoom($roomID)
    {
        return DB::table('devices')->where('room_id', $roomID)->get();
    }

    private function newRoomNotification($home_id,$notificationData)
    {
        $home = Home::find($home_id);
        $members = $home->members;
        foreach ($members as $member) {
            $user = User::find($member->member_id);
            $user->notify(new RoomCreated($notificationData));
        }
    }
}
