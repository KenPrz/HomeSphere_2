<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class apiKeyController extends Controller
{
    public function getMyKey($homeData){
        return DB::table("home_api_keys")
            ->where('home_id',$homeData->id)
            ->first();
    }

    public function generateNewKey($homeData){
        $newKey = Str::random(64);
    
        $data = DB::table('home_api_keys')
        ->where('home_id', $homeData->id)
        ->update(['api_key' => $newKey, 'updated_at' => now()]);

        if($data){
            return $newKey;
        }else{
            return false;
        }
    }
}
//auua7k8fVrwLwnC957zDmCknwGUS2tkJ1VYxYPcOEPVvL6NQnWu6F1BTJqdA6wm7
//ciIlhWCFojFVxv2MPv44okQ7p0jIK08FFBdPbCcOc0zEhJZaGwE4py4yRjzL9Ruk