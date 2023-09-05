<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $user = auth()->user();
        $homeData = $this->findHomeData($user);

        if ($homeData) {
            return Inertia::render('Dashboard', ['homeData' => $homeData]);
        }

        return redirect()->route('create_home');
    }

    private function findHomeData($user)
    {
        $homeData = DB::table('homes')->where('owner_id', $user->id)->first();

        if (!$homeData) {
            $homeMember = DB::table('home_member')->where('member_id', $user->id)->first();

            if ($homeMember) {
                $homeData = DB::table('homes')->where('id', $homeMember->home_id)->first();
            }
        }

        return $homeData;
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

        DB::table('home_member')->insert([
            'home_id' => DB::table('homes')->where('invite_code', $invite_code)->first()->id,
            'member_id' => $owner_id,
            'created_at' => now(),
        ]);
        User::where('id', Auth::id())->update(['is_online' => true]);
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
        $user_id = auth()->user()->id;
        $home_id = DB::table('homes')->where('invite_code', $invite_code)->first()->id;
        DB::table('home_member')->insert([
            'home_id' => $home_id,
            'member_id' => $user_id,
            'created_at' => now(),
        ]);
        DB::table('rooms')->insert([
            'room_name' => 'Default Room',
            'home_id' => $home_id,
            'room_owner_id' => $user_id,
            'created_at' => now(),
        ]);
        User::where('id', Auth::id())->update(['is_online' => true]);
        return redirect()->route('dashboard');
    }
}