<?php

namespace App\Http\Controllers;

use App\Http\Controllers\apiKeyController;
use App\Http\Controllers\AppUtilities;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
class SettingsController extends Controller
{
    public function index(){

        $appUtilities = New AppUtilities;

        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);
        $homeMembers = $appUtilities->getHomeMembers($homeData->id);
        if($user->id == $homeData->owner_id){
            $apiKey = $appUtilities->getApiKey($homeData);
            return Inertia::render('Settings/Main',[
                'homeData' => $homeData,
                'homeMembers' => $homeMembers,
                'api_key' => $apiKey
            ]);
        }
        else{
            return Inertia::render('Settings/Main',[
                'homeData' => $homeData,
                'homeMembers' => $homeMembers,
                'api_key' => null,
            ]);
        }

    }

    public function generateNewKey(Request $request){
        $api_key = New apiKeyController;
        $appUtilities = New AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);

        $newKey = $appUtilities->generateNewKey($user, $api_key);
    }
}
