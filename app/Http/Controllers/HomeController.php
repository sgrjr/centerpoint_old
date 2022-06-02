<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Helpers\Application;
use App\Helpers\Viewer;

use Auth;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'user' => Auth::user(),
            'application' => Application::props(Auth::user())
        ]);
    }
}
