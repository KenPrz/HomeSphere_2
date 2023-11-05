<?php

namespace App\Http\Controllers;

use App\Models\room;
use App\Models\User;
use App\Http\Controllers\AppUtilities;
use App\Models\humidity_sensor;
use App\Models\temp_sensor;
use App\Http\Controllers\AppliancesController;
use App\Http\Requests\HomeCreation\JoinHomeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class HomeCreationController extends Controller
{

    public function create_home()
    {
        return Inertia::render('CreateHome/Create');
    }

    public function verify()
    {
        $getAppliances = new AppliancesController();

        $user = auth()->user();
        $appUtilities = New AppUtilities;
        
        $homeData = $appUtilities->findHomeData($user);
        if(!$homeData) {
            return redirect()->route('create_home');
        }
        else if ($homeData->role == 'member' || $homeData->role == 'owner') {
            $rooms = Room::with('devices', 'tempSensor', 'humiditySensor', 'motionSensor')
                ->where('home_id', $homeData->id)
                ->select(['rooms.*'])
                ->addSelect(DB::raw('(SELECT COUNT(*) FROM devices WHERE devices.room_id = rooms.id) as device_count'))
                ->get();
            $appliances = $getAppliances->getAppliances($homeData);
            $userList = DB::table('home_members')->where('home_id', $homeData->id)
                ->join('users', 'home_members.member_id', '=', 'users.id')
                ->get(['users.firstName', 'users.lastName','users.profile_image', 'users.is_online']);
                // dd($appliances);
                $api_key = $appUtilities->getApiKey($homeData);
                return Inertia::render('Dashboard', 
                [   
                    'userData' => $homeData,
                    'userList' => $userList, 
                    'appliances' => $appliances,
                    'rooms' => $rooms,
                    'api_key' => $api_key,
                ]);
        }
        else if ($homeData->role == 'pending') {
            return Inertia::render('Dashboard',[
                'userData' => $homeData,
                'userList' => null, 
                'appliances' => null,
                'rooms' => null,
                'api_key' => null,
            ]);
        }
    }


    /**
     * Home Creation function.
     */
    public function new_home(Request $request)
    {
        $request->validate([
            'home_name' => ['required', 'string', 'max:255'],
            'name_of_room' => ['required', 'string', 'max:255'],
        ]);

        $invite_code = Str::random(16);
        $owner_id = auth()->user()->id;
        DB::table('homes')->insert([
            'home_name' => $request->home_name,
            'invite_code' => $invite_code,
            'owner_id' => $owner_id,
            'created_at' => now(),
        ]);
        
        $room = Room::create([
            'room_name' => $request->name_of_room,
            'home_id' => DB::table('homes')->where('invite_code', $invite_code)->first()->id,
            'room_owner_id' => $owner_id,
            'created_at' => now(),
        ]);

        temp_sensor::create([
            'room_id' => $room->id,
            'temperature' => null,
        ]);
    
        humidity_sensor::create([
            'room_id' => $room->id,
            'humidity' => null,
        ]);

        DB::table('home_members')->insert([
            'home_id' => DB::table('homes')->where('invite_code', $invite_code)->first()->id,
            'member_id' => $owner_id,
            'role' => 'owner',
            'joined_on' => now(),
            'created_at' => now(),
        ]);

        DB::table('home_api_keys')->insert([
            'home_id' => DB::table('homes')->where('invite_code', $invite_code)->first()->id,
            'api_key' => Str::random(64),
            'created_at' => now(),
        ]);
        User::where('id', Auth::id())->update(['is_online' => true, 'has_home' => true]);
        return redirect()->route('dashboard');
    }
    
    /**
     * Non member join function
     * @param JoinHomeRequest $request
     * @return mixed
     */
    public function join_home(JoinHomeRequest $request)
    {
        $validated = $request->validated();
        if ($validated) {
            $invite_code = $validated['home_code'];
            $user_id = auth()->user()->id;
            $home_id = DB::table('homes')->where('invite_code', $invite_code)->first()->id;
            try {
                DB::transaction(function () use ($home_id, $user_id) {
                    DB::table('home_members')->insert([
                        'home_id' => $home_id,
                        'member_id' => $user_id,
                        'role' => 'pending',
                        'applied_on' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    User::where('id', Auth::id())->update(['is_online' => true, 'has_home' => false]);
                });
                return redirect()->route('dashboard');
            } catch (\Exception $e) {
                // Handle the exception here
                return back()->route('/welcome')->with('error', 'An error occurred while joining the home. Please try again later.');
            }
        }
    }
}