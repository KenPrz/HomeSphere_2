<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Home;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\NewKeyRequest;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\AppUtilities;
use App\Http\Requests\Settings\HomeDeleteRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NotificationHandler;
use App\Notifications\HasLeft;

class SettingsController extends Controller
{
    /**
     * SettingsController constructor.
     *
     * @param AppUtilities $appUtilities
     * @param ApiKeyController $ApiKeyController
     */
    private $notificationHandler;
    private $appUtilities;
    private $ApiKeyController;

    public function __construct(AppUtilities $appUtilities, ApiKeyController $ApiKeyController, NotificationHandler $notificationHandler)
    {
        $this->notificationHandler = $notificationHandler;
        $this->appUtilities = $appUtilities;
        $this->ApiKeyController = $ApiKeyController;
    }

    /**
     * Display the settings page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $user = auth()->user();
        $notifications = $this->notificationHandler->getNotifications($user);
        $homeData = $this->appUtilities->findHomeData($user);
        $homeMembers = $this->appUtilities->getHomeMembers($homeData->id);
        $api_key = ($homeData->role == ('admin' || 'owner')) ? $this->appUtilities->getApiKey($homeData) : null;

        return Inertia::render('Settings/Main', [
            'notifications' => $notifications,
            'homeData' => $homeData,
            'homeMembers' => $homeMembers,
            'api_key' => $api_key,
        ]);
    }
    /**
     * Generate a new API key for the authenticated user's home data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */

    public function generateNewApiKey(NewKeyRequest $request)
    {   
        $validated = $request->validated();
        if($validated){
            $user = auth()->user();
            $homeData = $this->appUtilities->findHomeData($user);
            $this->ApiKeyController->generateNewKey($homeData);
        }
    }

    /**
     * Generate a new invite key for a home and update it in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function generateNewInviteKey(Request $request){
        $new_invite_code = Str::random(16);
        DB::table('homes')->where('id', $request->homeData['id'])
            ->update(['invite_code'=>$new_invite_code,'updated_at'=>now()]);
    }
    /**
     * Leave the user's home and remove them from the home_members table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveHome(Request $request){
        dd($request->all());
        // $request ->validate([
        //         'user'=> 'required',
        //     ]);
        // $user = auth()->user();
        // $homeData = $this->appUtilities->findHomeData($user);
        // DB::transaction(function () use ($request) {
        //     DB::table('users')->where('id', $request->user['id']) -> update(['has_home' => false]);
        //     DB::table('home_members')->where('member_id', $request->user['id'] )->delete();
        // });
        // $notificationData = [
        //     'title' => 'User Left',
        //     'body'=> 'has has left the home.',
        //     'user' => $user->id,
        //     'type' => 'delete',
        // ];
        // $this->notifyOnLeft($homeData->id, $notificationData);
        // return redirect()->route('verify')->with('success','test');
    }

    /**
     * Delete a home and its members from the database.
     *
     * @param  \App\Http\Requests\Settings\HomeDeleteRequest;  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteHome(HomeDeleteRequest $request){
        $validated = $request->validated();
        if ($validated) {
            $user = auth()->user();
            $homeData = $this->appUtilities->findHomeData($user);
            DB::transaction(function() use($homeData,$user){
                DB::table('users')->where('id', $user->id)->update(['has_home' => 0]);
                DB::table('homes')->where('id', $homeData->id)->delete();
                DB::table('home_members')->where('home_id', $homeData->id)->delete();
            });
            return redirect()->route('verify')->with('success', 'home deleted');
        } else {
            return redirect()->back()->with('error', 'error validation');
        }
    }
    private function notifyOnLeft($home_id,$notificationData){
        // dd($home_id);
        $home = Home::find($home_id);
        $members = $home->members->where('role','admin','owner')->where('member_id','!=',auth()->user()->id);
            foreach ($members as $member) {
                $user = User::find($member->member_id);
                $user->notify(new HasLeft($notificationData));
            }
    }

    public function toggleMotionNotifications(Request $request){
        $user = auth()->user();
        $user->receive_motion_alerts = $request->receive_motion_alerts;
        $user->save();
    }

}
