<?php

namespace App\Http\Controllers;
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
        $homeData = DB::table('homes')->where('owner_id', $user->id)->first();
    
        if ($homeData) {
            return Inertia::render('Dashboard', ['homeData' => $homeData]);
        } else {
            return redirect()->route('create_home');
        }
    }
    

    /**
     * Home Creation function.
     */
    public function new_home(Request $request){
        $request->validate([
            'home_name' => ['required', 'string', 'max:255'],
            'number_of_rooms' => ['required', 'integer', 'max:255'],
        ]);

        $invite_code = Str::random(16);
        $owner_id = auth()->user()->id;

        DB::table('homes')->insert([
            'home_name' => $request->home_name,
            'number_of_rooms' => $request->number_of_rooms,
            'invite_code' => $invite_code,
            'owner_id' => $owner_id,
            'created_at' => now(),
        ]);

        return redirect()->route('dashboard');

    }

}
