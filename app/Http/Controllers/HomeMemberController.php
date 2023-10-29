<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AppUtilities;
class HomeMemberController extends Controller
{
    public function approveUser(Request $request){

        $appUtilities = New AppUtilities;

        $userData = $request->all();

        $user = User::where('id',$userData['member']['id'])->first();
        
        $homeData = $appUtilities->findHomeData($user);
        $this->updateUser($homeData, $user->id);
    }

    public function rejectUser(Request $request){
        dd($request->all());
    }

    protected function updateUser($homeData, $userId)
    {
        return DB::transaction(function () use ($homeData, $userId) {
            DB::table('users')
            ->where('id', $userId)
                ->update(['has_home' => true]);

            DB::table('home_members')
            ->where('home_id', $homeData->id)
                ->where('member_id', $userId)
                ->update([
                    'role' => 'member',
                    'joined_on' => now()
                ]);
        });
    }
    
}