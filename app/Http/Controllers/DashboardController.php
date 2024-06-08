<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {

        $projects = Project::where('is_active', true)->filterByRole(auth()->user())->count();
        $cameras = Camera::where('is_active', true)->filterByRole(auth()->user())->count();

        return view('dashboard', compact('projects', 'cameras'));
    }
}
