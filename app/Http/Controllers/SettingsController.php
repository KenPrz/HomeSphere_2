<?php

namespace App\Http\Controllers;

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
        $apiKey = $appUtilities->getApiKey($homeData);
        $homeMembers = $appUtilities->getHomeMembers($homeData->id);
        return Inertia::render('Settings/Main',[
            'homeData' => $homeData,
            'homeMembers' => $homeMembers,
            'api_key' => $apiKey
        ]);
    }
}
