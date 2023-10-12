<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class ModesController extends Controller
{
    public function index(){
        return Inertia::render('Modes/Main');
    }

    public function editMode(Request $request){
        $request -> validate([
            'mode_name' => 'required | string | max:20',
        ]);
        // dd($request->all());
        $room_name = $request->input('mode_name');
        dd($room_name);
    }
    
}
