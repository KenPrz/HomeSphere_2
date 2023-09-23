<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
class RoomsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $homeData = $this->findHomeData($user);

        $roomData = DB::table('rooms')
            ->leftJoin('devices', 'rooms.id', '=', 'devices.room_id')
            ->select('rooms.*', DB::raw('count(devices.id) as device_count'))
            ->where('rooms.home_id', $homeData->id)
            ->groupBy('rooms.id')
            ->get();

        return Inertia::render('Rooms/Main', [
            'rooms' => $roomData,
        ]);
    }
    public function addRoom(Request $request){
        $user = auth()->user();

        $homeData = $this->findHomeData($user);

        $roomData = DB::table('rooms')->where('home_id', $homeData->id)->get();
        $roomName = $request->input('room_name');
        $roomData = DB::table('rooms')->insert([
            'room_name' => $roomName,
            'home_id' => $homeData->id,
            'room_owner_id' => $user->id,
            'created_at' => now(),
        ]);
        if($roomData){
            return redirect()->back();
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function deleteRoom(Request $request){
        $user = auth()->user();

        $homeData = $this->findHomeData($user);

        $roomData = DB::table('rooms')->where('home_id', $homeData->id)->get();
        $roomID = $request->input('roomID');
        $roomData = DB::table('rooms')->where('id', $roomID)->delete();
        return redirect()->back();
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
}
