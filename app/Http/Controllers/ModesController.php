<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\room;
class ModesController extends Controller
{
    private $appUtilities;
    private $getAppliances;
    /**
     * ModesController constructor.
     *
     * @param AppUtilities $appUtilities The AppUtilities instance.
     * @param AppliancesController $getAppliances The AppliancesController instance.
     */
    public function __construct(AppUtilities $appUtilities, AppliancesController $getAppliances)
    {
        $this->appUtilities = $appUtilities;
        $this->getAppliances = $getAppliances;
    }

    public function index()
    {
        $user = auth()->user();
        $homeData = $this->appUtilities->findHomeData($user);
        $roomsData = $this->getRooms($homeData->id);
        $appliances = $this->getAppliances->getAppliances($homeData);
        $homeId = $homeData->id;
    
        $modes = DB::table('modes')
            ->select('modes.*', 'mode_devices.device_list')
            ->join('mode_devices', 'modes.id', '=', 'mode_devices.mode_id')
            ->where('modes.home_id', $homeId)
            ->get();
    
        // Decode the device_list for each mode
        foreach ($modes as $mode) {
            $mode->device_list = json_decode($mode->device_list, true);
        }
    
        if (empty($modes[0])) {
            $modes = null;
        }
    
        return Inertia::render('Modes/Main', [
            'homeData' => $homeData,
            'modes' => $modes,
            'roomsData' => $roomsData,
            'devices' => $appliances,
        ]);
    }
    /**
     * Create a new mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function createMode(Request $request){
        $request -> validate([
            'mode_name' => 'required | string | max:20',
        ]);
        $user = auth()->user();
        $homeData = $this->appUtilities->findHomeData($user);
        DB::transaction(function () use ($homeData, $request, $user) {
            $modeId = DB::table('modes')->insertGetId([
                'home_id' => $homeData->id,
                'mode_name' => $request->mode_name, 
                'created_by' => $user->id,
                'created_at' => now()
            ]);
            DB::table('mode_devices')->insert([
                'mode_id' => $modeId,
                'device_list' => null,
                'created_at' => now()
            ]);
        });
    }
    /**
     * Update the mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function editMode(Request $request){
        $request -> validate([
            'mode_id' => 'required | integer',
            'mode_name' => 'required | string | max:20',
        ]);
        DB::table('modes')->where('id',$request->mode_id)->update([
            'mode_name' => $request->mode_name,
            'updated_at' => now()
        ]);
    }

    public function addDevice(Request $request){
        $request -> validate([
            'mode_id' => 'required | integer',
            'device_id' => 'required | integer',
            'room_id' => 'required | integer',
        ]);
        
        $room_data = DB::table('rooms')->where('id',$request->room_id)->first();
        $device_data = DB::table('devices')->where('id',$request->device_id)->first();
        $modeDevice = DB::table('mode_devices')->where('mode_id',$request->mode_id)->first();
        
        $existingDeviceList = json_decode($modeDevice->device_list, true) ?? [];

        $newDevice = [
            'device' => [
                'device_id' => $request->device_id,
                'device_name' => $device_data->device_name,
                'custom_name' => $device_data->custom_name,
                'device_type' => $device_data->device_type,
                'is_active' => false
            ],
            'room' => [
                'room_id' => $request->room_id,
                'room_name' => $room_data->room_name,
            ],
        ];

        array_push($existingDeviceList, $newDevice);

        $updatedModeDevices = json_encode($existingDeviceList);
        DB::table('mode_devices')->where('id',$request->mode_id)->update([
            'device_list' => $updatedModeDevices,
            'updated_at' => now()
        ]);
    }
    public function updateDeviceList(Request $request){
        $request -> validate([
            'mode_id' => 'required | integer',
            'device_list' => 'array',
        ]);
        if(count($request->device_list)==0){
            $request->device_list = null;
        }
        $updatedModeDevices = json_encode($request->device_list);
        DB::table('mode_devices')->where('id',$request->mode_id)->update([
            'device_list' => $updatedModeDevices,
            'updated_at' => now()
        ]);
    }
    /**
     * Schedule the mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function scheduleMode(Request $request){
        dd($request->all());
    }
    public function environmentMode(Request $request){
        dd($request->all());
    }

    /**
     * Delete a mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function deleteMode(Request $request){
        $request -> validate([
            'mode_id' => 'required | integer',
        ]);
        DB::table('modes')->where('id',$request->mode_id)->delete();
    }

    protected function getRooms($home_id){
        return Room::with('devices', 'tempSensor', 'humiditySensor', 'motionSensor')
                ->where('home_id', $home_id)
                ->select(['rooms.*'])
                ->addSelect(DB::raw('(SELECT COUNT(*) FROM devices WHERE devices.room_id = rooms.id) as device_count'))
                ->get();
    }
}

