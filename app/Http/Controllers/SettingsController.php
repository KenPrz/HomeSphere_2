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

        return Inertia::render('Settings/Main',[
            'homeData' => $homeData,
            'api_key' => $apiKey
        ]);
    }
}
