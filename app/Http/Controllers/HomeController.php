<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use App\Models\Developer;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function developers()
    {
        $developers = Developer::where('is_active', true)
            ->FilterByRole(auth()->user())
            ->paginate(12);

        return view('home.developers', compact('developers'));
    }

    public function projects(Developer $developer)
    {
        $projects = Project::where('is_active', true)
            ->where('developer_id', $developer->id)
            ->FilterByRole(auth()->user())
            ->paginate(12);

        return view('home.projects', compact('projects'));
    }

    public function cameras(Project $project)
    {
        $cameras = Camera::with(['photos' => function ($query) {
            return $query->limit(5)->whereDate('created_at', now())->latest();
        }])->where('is_active', true)
            ->where('project_id', $project->id)
            ->paginate(12);

        return view('home.cameras', compact('cameras'));
    }
}
