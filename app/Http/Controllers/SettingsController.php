<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Settings\NewKeyRequest;
use Inertia\Inertia;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\AppUtilities;
use Illuminate\Support\Facades\Hash;
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

    public function generateNewKey(NewKeyRequest $request)
    {   
        $validated = $request->validated();
        if($validated){
            $user = auth()->user();
            $homeData = $this->appUtilities->findHomeData($user);
            $this->apiKeyController->generateNewKey($homeData);
        }
    }
}
//0CQ3jK10Kp6h7Fy7W9q9b52u60TZHtY8VBWhgixZPULsisirQOBXfU92j54j3Zca
