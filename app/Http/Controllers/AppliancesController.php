<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Request;
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
        $searchData = Request::only('search');
        if ($searchData) {
            $appliances = $this->getFilteredAppliances($homeData, $searchData);
        } else {
            $appliances = $this->getAppliances($homeData);
        }
        return Inertia::render('Appliances/Main', [
            'filters' => Request::only('search'),
            'appliances' => $appliances,
        ]);
    }

    public function getFilteredAppliances($homeData, $searchData) {
        
        $data = DB::table('devices')
            ->select(
                'rooms.room_name',
                'devices.device_type',
                'devices.device_name',
                DB::raw('CASE WHEN devices.is_active = 1 THEN "Active" ELSE "Inactive" END AS is_active')
            )
            ->where('devices.room_id', $homeData->id)
            ->when($searchData['search'], function ($query, $search) {
                return $query->where('devices.device_name', 'like', "%$search%");
            })
            ->join('rooms', 'devices.room_id', '=', 'rooms.id')
            ->get();

        return $data;
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
