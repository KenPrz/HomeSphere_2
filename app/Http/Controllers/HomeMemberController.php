<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\HomeMembers\CheckMemberRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\AppUtilities;

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
            $this->updateUser($homeData, $user->id);
        }
    }

    public function rejectUser(Request $request)
    {
        $userData = $request->input('userData');
        $user = User::find($userData['id']);

        if ($user) {
            $homeData = $this->appUtilities->findHomeData($user);
            $this->deleteHomeMember($user->id, $homeData->id);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function kickUser(Request $request){
        $userData = $request->input('userData');
        $user = User::find($userData['id']);
        $homeData = $this->appUtilities->findHomeData($user);
        if ($user) {
            DB::transaction(function () use ($user, $homeData) {
                User::where('id', $user->id)->update(['has_home' => false]);
                DB::table('home_members')
                ->where('member_id', $user->id)
                ->where('home_id', $homeData->id)
                ->delete();
            });
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
}
