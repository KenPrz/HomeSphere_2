<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
class AppliancesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $homeData = $this->findHomeData($user);
        $appliances = DB::table('devices')
            ->select(
                'rooms.room_name',
                'devices.device_type',
                'devices.device_name',
                DB::raw('CASE WHEN devices.is_active = 1 THEN "Active" ELSE "Inactive" END AS is_active')
            )->where('rooms.home_id', $homeData->id)
            ->join('rooms', 'devices.room_id', '=', 'rooms.id')
            ->get();
    
        // Perform any additional operations on $appliances if needed
    
        return Inertia::render('Appliances/Main', [
            'appliances' => $appliances,
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
}
