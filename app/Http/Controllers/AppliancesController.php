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
        $appliances = $this->getFilteredAppliances($homeData->id, $searchData);
        return Inertia::render('Appliances/Main', [
            'homeData' => $homeData,
            'filters' => Request::only('search'),
            'appliances' => $appliances,
        ]);
    }

    public function getFilteredAppliances($home_id, $searchData) {
        $query = DB::table('devices')
            ->select(
                'devices.id',
                'rooms.room_name',
                'devices.device_type',
                'devices.device_name',
                'devices.is_active'
            )
            ->where('rooms.home_id', $home_id)
            ->join('rooms', 'devices.room_id', '=', 'rooms.id');
    
        if (!empty($searchData['search'])) {
            $searchTerm = $searchData['search'];
            $query->where(function ($query) use ($searchTerm) {
                $query->where('devices.device_name', 'like', "%$searchTerm%")
                    ->orWhere('devices.is_active', '=', $searchTerm)
                    ->orWhere('rooms.room_name', 'like', "%$searchTerm%");
            });
    
            // Add ORDER BY clause to sort by closeness
            $query->orderBy(DB::raw("CASE 
                WHEN devices.device_name LIKE '%$searchTerm%' THEN 1
                WHEN rooms.room_name LIKE '%$searchTerm%' THEN 2
                ELSE 3
            END"));
        }
        $appliances = $query->get();
        return $appliances;
    }
    
    

    public function getAppliances($homeData){
        return DB::table('devices')
                ->select(
                    'rooms.room_name',
                    'devices.id',
                    'devices.device_type',
                    'devices.device_name',
                    'devices.is_active'
                )->where('rooms.home_id', $homeData->id)
                ->join('rooms', 'devices.room_id', '=', 'rooms.id')
                ->get();
    }
}
