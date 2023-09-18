<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
class UserListController extends Controller
{
    public function index()
    {   $user = auth()->user();
        $userList = DB::table('home_members')->where('home_id', $user->home_id)->get();
        return Inertia::render('Home\Main', [
            'users' => $userList
        ]);
    }
}
