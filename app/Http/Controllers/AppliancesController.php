<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppUtilities;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AppliancesController extends Controller
{
    public function index(Request $request)
{
    $appUtilities = new AppUtilities();
    $user = auth()->user();
    $homeData = $appUtilities->findHomeData($user);
    $appliances = $this->getAppliances($homeData);

    return Inertia::render('Appliances/Main', [
        'appliances' => $appliances,
    ])->withViewData(['appliances' => $appliances]);
}


    public function getAppliances($homeData)
    {
        return DB::table('devices')
            ->select(
                'rooms.room_name as Room',
                'devices.device_type as Type',
                'devices.device_name',
                DB::raw('CASE WHEN devices.is_active = 1 THEN "Active" ELSE "Inactive" END AS is_active')
            )
            ->where('rooms.home_id', $homeData->id)
            ->join('rooms', 'devices.room_id', '=', 'rooms.id')
            ->get();
    }
}
