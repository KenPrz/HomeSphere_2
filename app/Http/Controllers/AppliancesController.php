<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
class AppliancesController extends Controller
{
    public function index()
    {
        $appliances = DB::table('devices')
            ->select(
                'rooms.room_name',
                'devices.device_type',
                'devices.device_name',
                DB::raw('CASE WHEN devices.is_active = 1 THEN "Active" ELSE "Inactive" END AS is_active')
            )
            ->join('rooms', 'devices.room_id', '=', 'rooms.id')
            ->get();
    
        // Perform any additional operations on $appliances if needed
    
        return Inertia::render('Appliances/Main', [
            'appliances' => $appliances,
        ]);
    }
}
