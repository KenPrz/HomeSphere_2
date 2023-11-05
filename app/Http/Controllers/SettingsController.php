<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Settings\NewKeyRequest;
use Inertia\Inertia;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\AppUtilities;
use App\Http\Requests\Settings\HomeDeleteRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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

    /**
     * Leave the user's home and remove them from the home_members table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveHome(Request $request){
        $request ->validate([
                'user'=> 'required',
            ]);
        DB::table('users')->where('id', $request->user) -> update(['has_home' => false]);
        DB::table('home_members')->where('member_id', $request->user )->delete();
        
        return redirect()->route('verify')->with('success','test');
    }

    public function deleteHome(HomeDeleteRequest $request){
        $validated = $request->validated();
        if( $validated ){
            if($validated){
                $user = auth()->user();
                $homeData = $this->appUtilities->findHomeData($user);
                DB::transaction(function() use($homeData){
                    DB::table('homes')->where('id', $homeData->id)->delete();
                    DB::table('home_members')->where('home_id',$homeData->id)->delete();
                    return redirect()->route('verify')->with('success','test');
                });
                return redirect()->route('verify')->with('success','test');
            }
        }else{
            return redirect()->back()->with('error','error validation');
        }
    }

}
