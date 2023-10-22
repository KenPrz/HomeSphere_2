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
        $appliances = $this->getFilteredAppliances($homeData, $searchData);
        return Inertia::render('Appliances/Main', [
            'filters' => Request::only('search'),
            'appliances' => $appliances,
        ]);
    }

    public function getFilteredAppliances($homeData, $searchData) {
        $query = DB::table('devices')
            ->select(
                'rooms.room_name',
                'devices.device_type',
                'devices.device_name',
                DB::raw('CASE WHEN devices.is_active = 1 THEN "true" ELSE "false" END AS is_active')
            )
            ->where('rooms.home_id', $homeData->id)
            ->join('rooms', 'devices.room_id', '=', 'rooms.id');
    
        if (!empty($searchData['search'])) {
            $searchTerm = $searchData['search'];
            $query->where(function ($query) use ($searchTerm) {
                $query->where('devices.device_name', 'like', "%$searchTerm%")
                    ->orWhere('devices.is_active', '=', $searchTerm)
                    ->orWhere('rooms.room_name', 'like', "%$searchTerm%");
            });
        }
    
        $appliances = $query->get();
        return $appliances;
    }
    

    public function getAppliances($homeData){
        return DB::table('devices')
                ->select(
                    'rooms.room_name',
                    'devices.device_type',
                    'devices.device_name',
                    DB::raw('CASE WHEN devices.is_active = 1 THEN "true" ELSE "false" END AS is_active')
                )->where('rooms.home_id', $homeData->id)
                ->join('rooms', 'devices.room_id', '=', 'rooms.id')
                ->get();
    }
}
