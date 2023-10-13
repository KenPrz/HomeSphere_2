<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppUtilities;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
class AppliancesController extends Controller
{
    public function index()
    {
        
        $appUtilities = new AppUtilities();
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);
        $appliances = $this->getAppliances($homeData);
        // Perform any additional operations on $appliances if needed
    
        return Inertia::render('Appliances/Main', [
            'appliances' => $appliances,
        ]);
    }
    public function getAppliances($homeData){
        return DB::table('devices')
                ->select(
                    'rooms.room_name',
                    'devices.device_type',
                    'devices.device_name',
                    DB::raw('CASE WHEN devices.is_active = 1 THEN "Active" ELSE "Inactive" END AS is_active')
                )->where('rooms.home_id', $homeData->id)
                ->join('rooms', 'devices.room_id', '=', 'rooms.id')
                ->get();
    }
}
