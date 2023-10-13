<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\AppUtilities;

use App\Http\Controllers\AppliancesController;
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
        if ($homeData) {
            $rooms = DB::table('rooms')
                ->leftJoin('devices', 'rooms.id', '=', 'devices.room_id')
                ->select('rooms.*', DB::raw('count(devices.id) as device_count'))
                ->where('rooms.home_id', $homeData -> id)
                ->groupBy('rooms.id')
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
        return redirect()->route('create_home');
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

        DB::table('rooms')->insert([
            'room_name' => $request->name_of_room,
            'home_id' => DB::table('homes')->where('invite_code', $invite_code)->first()->id,
            'room_owner_id' => $owner_id,
            'created_at' => now(),
        ]);

        DB::table('home_members')->insert([
            'home_id' => DB::table('homes')->where('invite_code', $invite_code)->first()->id,
            'member_id' => $owner_id,
            'is_owner' => true,
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
     * Join Home function.
     */
    public function join_home(Request $request)
    {
        $request->validate([
            'home_code' => ['required', 'string', 'max:255'],
        ]);
        $invite_code = $request->home_code;
        $home = DB::table('homes')->where('invite_code', $invite_code)->first();
    
        // Check if the home with the given invite code exists
        if (!$home) {
            return inertia()->render('CreateHome/Create',[
                'error' => 'Home with the given invite code does not exist.',
            ]);
        }

        $user_id = auth()->user()->id;
        $home_id = DB::table('homes')->where('invite_code', $invite_code)->first()->id;
        DB::table('home_members')->insert([
            'home_id' => $home_id,
            'member_id' => $user_id,
            'is_owner' => false,
            'created_at' => now(),
        ]);
        User::where('id', Auth::id())->update(['is_online' => true, 'has_home' => true]);
        return redirect()->route('dashboard');
    }
}