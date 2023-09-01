<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class HomeCreationController extends Controller
{
    public function create_home()
    {
        return Inertia::render('CreateHome/Create');
    }
}
