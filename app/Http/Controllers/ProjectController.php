<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Developer;
use App\Models\Project;
use App\Traits\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    use FileHelper;

    public function index()
    {
        return view('project.index');
    }

    public function create()
    {
        $developers = Developer::selectRaw('id as value, name as label')->where('is_active', true)->get();

        return view('project.create', compact('developers'));
    }

    public function store(ProjectRequest $request)
    {
        $inputs = $request->validated();

        if (str_contains($inputs['logo'], 'Temps')) {
            $inputs['logo'] = $this->moveFileFromTempAndGetName($inputs['logo'], Project::class);
        }

        Project::create($inputs);

        return response()->json('project created successfully', Response::HTTP_CREATED);
    }

    public function show(Project $project)
    {
        //
    }

    public function edit(Project $project)
    {
        $developers = Developer::selectRaw('id as value, name as label')->where('is_active', true)->get();

        return view('project.edit', compact('developers', 'project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $inputs = $request->validated();

        if ($project->logo != $inputs['logo']) $this->deleteFile($project->logo);

        if (str_contains($inputs['logo'], 'Temps'))
            $inputs['logo'] = $this->moveFileFromTempAndGetName($inputs['logo'], Developer::class);


        $project->update($inputs);

        return response()->json('project updated successfully', Response::HTTP_NO_CONTENT);
    }

    public function destroy(Project $project)
    {
        //
    }
}
