<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeData extends Controller
{
    public function getHomeData()
    {
        $user = auth()->user();
        $home = $user->home;
        $appliances = $home->appliances;
        $users = $home->users;
        $data = [
            'user' => $user,
            'home' => $home,
            'appliances' => $appliances,
            'users' => $users,
        ];
        return Inertia::render('Home', $data);
    }
}
