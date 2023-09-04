<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class AppliancesController extends Controller
{
    public function index()
    {
        return Inertia::render('Appliances/Main');
    }
}
