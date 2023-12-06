<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\User;
use App\Events\UserAcceptedEvent;
use App\Events\userKickedEvent;
use App\Http\Requests\HomeMembers\CheckMemberRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\AppUtilities;
use App\Events\UserPromotedEvent;
use App\Events\UserDemotedEvent;
use App\Notifications\HasJoined;
use App\Notifications\WasDemoted;
use App\Notifications\WasKicked;
use App\Notifications\WasPromoted;

class HomeMemberController extends Controller
{
    protected $appUtilities;

    public function __construct(AppUtilities $appUtilities)
    {
        $this->appUtilities = $appUtilities;
    }

    public function approveUser(Request $request)
    {
        $userData = $request->input('userData');
        $user = User::find($userData['id']);
        if ($user) {
            $homeData = $this->appUtilities->findHomeData($user);
            $data = $this->updateUser($homeData, $user->id);
            if($data){
                $notificationData = [
                    'title' => 'User Joined',
                    'body'=> $user->firstName.' has joined this home approved by '. auth()->user()->firstName . ' ' . auth()->user()->lastName .'.' ,
                    'user' => $user->id,
                    'type' => 'update',
                ];
                $this->notifyOnJoin($homeData->id, $notificationData);
                event(new UserAcceptedEvent($user->id));
            }
        }
    }
    public function rejectUser(Request $request)
    {
        $userData = $request->input('userData');
        $user = User::find($userData['id']);

        if ($user) {
            $homeData = $this->appUtilities->findHomeData($user);
            $data = $this->deleteHomeMember($user->id, $homeData->id);
            if($data){
                event(new userKickedEvent($userData['id']));
            }
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function promoteUser(Request $request)
    {
        $request->validate([
            'userData' => 'required',
        ]);
        $user = User::find($request->input('userData')['id']);
        $homeData = $this->appUtilities->findHomeData($user);
        if ($user) {
            DB::table('home_members')
                ->where('home_id', $homeData->id)
                ->where('member_id', $user->id)
                ->update(['role' => 'admin']);
                $notificationData = [
                    'title' => 'User Promoted',
                    'body'=> 'has promoted '. $user->firstName . ' to admin.',
                    'user' => auth()->user()->id,
                    'type' => 'update',
                ];
                $this->notifyOnPromote($homeData->id, $notificationData);
                event(new UserPromotedEvent($user->id));
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function demoteUser(Request $request)
    {
        $request->validate([
            'userData' => 'required',
        ]);
        $user = User::find($request->input('userData')['id']);
        $homeData = $this->appUtilities->findHomeData($user);
        if ($user) {
            DB::table('home_members')
                ->where('home_id', $homeData->id)
                ->where('member_id', $user->id)
                ->update(['role' => 'member']);
                $notificationData = [
                    'title' => 'User Demoted',
                    'body'=> 'has demoted '. $user->firstName . ' to member.',
                    'user' => auth()->user()->id,
                    'type' => 'update',
                ];
                $this->notifyOnDemote($homeData->id, $notificationData);
            event(new UserDemotedEvent($user->id));
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    public function kickUser(Request $request){
        $userData = $request->input('userData');
        $user = User::find($userData['id']);
        $authenticatedUser = auth()->user();
        $homeData = $this->appUtilities->findHomeData($user);
        if ($user) {
            $notificationData = [
                'title' => 'User Kicked',
                'body'=> 'has kicked '. $user->firstName . ' ' . $user->lastName .'.',
                'user' => $authenticatedUser->id,
                'type' => 'delete',
            ];
            $this->notifyOnKick($homeData->id, $notificationData);

            DB::transaction(function () use ($user, $homeData) {
                User::where('id', $user->id)->update(['has_home' => false]);
                DB::table('home_members')
                ->where('member_id', $user->id)
                ->where('home_id', $homeData->id)
                ->delete();
            });
            event(new userKickedEvent($user['id']));
        }else{
            return response()->json(['message'=> 'User Not Found'],404);
        }
    }

    protected function updateUser($homeData, $userId)
    {
        try {
            DB::transaction(function () use ($homeData, $userId) {
                User::where('id', $userId)->update(['has_home' => true]);

                DB::table('home_members')
                    ->where('home_id', $homeData->id)
                    ->where('member_id', $userId)
                    ->update([
                        'role' => 'member',
                        'joined_on' => now(),
                        'applied_on' => null,
                    ]);
            });

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function deleteHomeMember($userId, $homeId)
    {
        return DB::table('home_members')
            ->where('member_id', $userId)
            ->where('home_id', $homeId)
            ->delete();
    }

    private function notifyOnKick($home_id,$notificationData){
        $home = Home::find($home_id);
        $members = $home->members->where('role','!=','pending')->where('member_id','!=',auth()->user()->id);
            foreach ($members as $member) {
                $user = User::find($member->member_id);
                $user->notify(new WasKicked($notificationData));
            }
    }
    private function notifyOnPromote($home_id,$notificationData){
        $home = Home::find($home_id);
        $members = $home->members->where('role','!=', 'pending')->where('member_id','!=',auth()->user()->id);
            foreach ($members as $member) {
                $user = User::find($member->member_id);
                $user->notify(new WasPromoted($notificationData));
            }
    }
    private function notifyOnDemote($home_id,$notificationData){
        $home = Home::find($home_id);
        $members = $home->members->where('role','!=', 'pending')->where('member_id','!=',auth()->user()->id);
            foreach ($members as $member) {
                $user = User::find($member->member_id);
                $user->notify(new WasDemoted($notificationData));
            }
    }
    private function notifyOnJoin($home_id,$notificationData){
        $home = Home::find($home_id);
        $members = $home->members->where('role','!=', 'pending')->where('member_id','!=',auth()->user()->id);
            foreach ($members as $member) {
                $user = User::find($member->member_id);
                $user->notify(new HasJoined($notificationData));
            }
    }
}
