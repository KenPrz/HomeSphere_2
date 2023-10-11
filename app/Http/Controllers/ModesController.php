<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class ModesController extends Controller
{
    public function index(){
        return Inertia::render('Modes/Main');
    }

    
}
