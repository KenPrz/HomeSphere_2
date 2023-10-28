<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CancelRequest extends Controller
{
    public function cancel(){
        $user = auth()->user();
        
        $home = DB::table('home_members')->where('member_id', $user->id)->delete();

        if($home){
            return redirect()->route('create_home');
        }
        else{
            return redirect()->route('dashboard');
        }
    }
}
