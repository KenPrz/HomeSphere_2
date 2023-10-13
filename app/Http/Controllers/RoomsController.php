<?php

namespace App\Http\Controllers;

use App\Models\room;
use App\Http\Controllers\AppUtilities;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
class RoomsController extends Controller
{   
    public function index()
    {
        $appUtilities = New AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);
        $roomData = $this->getRoomData($homeData->id);
        return Inertia::render('Rooms/Main', [
            'homeData' => $homeData,
            'rooms' => $roomData,
        ]);
    }

    public function addRoom(Request $request)
    {
        $appUtilities = new AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);

        $roomName = $request->input('room_name');
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

    private function getRoomData($homeID)
    {
        return Room::with('devices')
        ->where('home_id', $homeID)
        ->select(['rooms.*'])
        ->addSelect(DB::raw('(SELECT COUNT(*) FROM devices WHERE devices.room_id = rooms.id) as device_count'))
        ->get();
    }

    private function createRoom($roomName, $homeID, $roomOwnerID)
    {
        DB::table('rooms')->insert([
            'room_name' => $roomName,
            'home_id' => $homeID,
            'room_owner_id' => $roomOwnerID,
            'created_at' => now(),
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
