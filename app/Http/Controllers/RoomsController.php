<?php

namespace App\Http\Controllers;

use App\Models\motion_sensor;
use App\Models\room;
use App\Http\Controllers\AppUtilities;
use App\Http\Requests\Room\CreateRoomRequest;
use App\Models\humidity_sensor;
use App\Models\temp_sensor;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
class RoomsController extends Controller
{   
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
        $this->createRoom($roomName, $homeData->id, $user->id);

        return redirect()->back();
    }

    public function deleteRoom(Request $request)
    {   
        $appUtilities = new AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);

        $roomID = $request->input('roomID');
        $this->deleteRoomByID($roomID);

        return redirect()->back();
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

    private function createRoom($roomName, $homeID, $roomOwnerID)
    {
        $room = Room::create([
            'room_name' => $roomName,
            'home_id' => $homeID,
            'room_owner_id' => $roomOwnerID,
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
}
