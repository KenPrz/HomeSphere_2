<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class RoomsController extends Controller
{
    public function index(){
            return Inertia::render('Rooms/Main');
    }
}
