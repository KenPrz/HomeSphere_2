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
            ->select('modes.*', 'mode_devices.device_list', 'mode_schedules.*', 'mode_environments.*')
            ->join('mode_devices', 'modes.id', '=', 'mode_devices.mode_id')
            ->join('mode_schedules', 'modes.id', '=', 'mode_schedules.mode_id')
            ->join('mode_environments', 'modes.id', '=', 'mode_environments.mode_id')
            ->where('modes.home_id', $homeId)
            ->get();
    
        foreach ($modes as $mode) {
            $mode->days_of_week = json_decode($mode->days_of_week);
        }

        foreach ($modes as $mode) {
            $mode->device_list = json_decode($mode->device_list, true);
        }
    
        if (empty($modes[0])) {
            $modes = null;
        }
        // dd($modes, $homeData);
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
            DB::table('mode_schedules')->insert([
                'mode_id' => $modeId,
                'frequency' => null,
                'start_time' => null,
                'end_time' => null,
                'days_of_week' => null,
                'created_at' => now()
            ]);
            DB::table('mode_environments')->insert([
                'mode_id' => $modeId,
                'trigger_sensor' => null,
                'threshold' => null,
                'value' => null,
                'room_id' => null,
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
        $request -> validate([
            'mode_id' => 'required | integer',
        ]);
        // ['repeat']['StartTime']['data']
        if($request->activation['type'] == 'schedule'){
            $schedule_data = $request->activation['repeat'];
            if($schedule_data['frequency'] == 'weekly'){
                $daysOfWeek = json_encode($schedule_data['days']);
                DB::table('mode_schedules')->where('mode_id',$request->mode_id)->update([
                    'frequency' => $schedule_data['frequency'],
                    'start_time' => $schedule_data['StartTime']['data'],
                    'end_time' => $schedule_data['EndTime']['data'],
                    'days_of_week' => $daysOfWeek,
                    'updated_at' => now()
                ]);
                DB::table('modes')->where('id',$request->mode_id)->update([
                    'activation_type'=>'schedule',
                    'updated_at' => now()
                ]);
            }else if($schedule_data['frequency'] == 'daily'){
                DB::table('mode_schedules')->where('mode_id',$request->mode_id)->update([
                    'frequency' => $schedule_data['frequency'],
                    'start_time' => $schedule_data['StartTime']['data'],
                    'end_time' => $schedule_data['EndTime']['data'],
                    'days_of_week' => null,
                    'updated_at' => now()
                ]);
                DB::table('modes')->where('id',$request->mode_id)->update([
                    'activation_type'=>'schedule',
                    'updated_at' => now()
                ]);
            }
        }
    }
    public function environmentMode(Request $request){
        $request -> validate([
            'mode_id' => 'required | integer',
        ]);
        if($request->activation['type'] == 'environment'){
            $environment_data = $request->activation['value'];
            DB::transaction(function () use ($request, $environment_data) {
                DB::table('mode_environments')
                    ->where('mode_id', $request->mode_id)
                    ->update([
                        'trigger_sensor' => $environment_data['trigger_sensor'],
                        'threshold' => $environment_data['threshold'],
                        'value' => $environment_data['value'],
                        'room_id' => $environment_data['room_id'],
                        'updated_at' => now(),
                    ]);
                DB::table('modes')->where('id', $request->mode_id)->update([
                    'activation_type'=>'environment',
                    'updated_at' => now(),
                ]);
            });
        }
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

