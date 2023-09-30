<?php

namespace App\Http\Controllers;

use App\Models\room;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
class RoomsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $homeData = $this->findHomeData($user);
        $roomData = $this->getRoomData($homeData->id);

        return Inertia::render('Rooms/Main', [
            'rooms' => $roomData,
        ]);
    }

    public function addRoom(Request $request)
    {
        $user = auth()->user();
        $homeData = $this->findHomeData($user);

        $roomName = $request->input('room_name');
        $this->createRoom($roomName, $homeData->id, $user->id);

        return redirect()->back();
    }

    public function deleteRoom(Request $request)
    {
        $user = auth()->user();
        $homeData = $this->findHomeData($user);

        $roomID = $request->input('roomID');
        $this->deleteRoomByID($roomID);

        return redirect()->back();
    }

    public function openRoom($roomID)
    {
        $user = auth()->user();
        $roomData = $this->getRoomByID($roomID);
        $deviceData = $this->getDevicesInRoom($roomID);

        return Inertia::render('Rooms/Room', [
            'activeComponent' => 'Room ' . $roomData->id,
            'room' => $roomData,
            'devices' => $deviceData,
        ]);
    }

    private function findHomeData($user)
    {
        $homeData = DB::table('homes')->where('owner_id', $user->id)->first();
        if (!$homeData) {
            $homeMember = DB::table('home_members')->where('member_id', $user->id)->first();

            if ($homeMember) {
                $homeData = DB::table('homes')->where('id', $homeMember->home_id)->first();
            }
        }
        return $homeData;
    }

    private function getRoomData($homeID)
    {
        return DB::table('rooms')
            ->leftJoin('devices', 'rooms.id', '=', 'devices.room_id')
            ->select('rooms.*', DB::raw('count(devices.id) as device_count'))
            ->where('rooms.home_id', $homeID)
            ->groupBy('rooms.id')
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
