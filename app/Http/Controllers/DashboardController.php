<?php

namespace App\Http\Controllers;

use App\Services\Weather;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request, Weather $weather): View
    {
        return view('dashboard', $weather->retrievePerceptionAndUVrays($request->user()));
    }
}
