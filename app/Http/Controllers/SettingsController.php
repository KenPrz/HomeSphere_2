<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\AppUtilities;

class SettingsController extends Controller
{
    private $appUtilities;
    private $apiKeyController;

    public function __construct(AppUtilities $appUtilities, ApiKeyController $apiKeyController)
    {
        $this->appUtilities = $appUtilities;
        $this->apiKeyController = $apiKeyController;
    }

    public function index()
    {
        $user = auth()->user();
        $homeData = $this->appUtilities->findHomeData($user);
        $homeMembers = $this->appUtilities->getHomeMembers($homeData->id);
        $api_key = ($user->id == $homeData->owner_id) ? $this->appUtilities->getApiKey($homeData) : null;

        return Inertia::render('Settings/Main', [
            'homeData' => $homeData,
            'homeMembers' => $homeMembers,
            'api_key' => $api_key,
        ]);
    }

    public function generateNewKey(Request $request)
    {   
        $validated = $request->validate([
            'oldApiKey' => 'required|string',
            'password' => 'required|confirmed',
        ]);
        
        $user = auth()->user();
        $homeData = $this->appUtilities->findHomeData($user);
        $oldKey = $this->apiKeyController->getMyKey($homeData);
        // work in this tonight
        dd($oldKey);
    }
}
