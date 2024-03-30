<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeveloperRequest;
use App\Models\Developer;
use App\Models\Project;
use App\Traits\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeveloperController extends Controller
{
    use FileHelper;

    public function index()
    {
        return view('developer.index');
    }

    public function create()
    {
        return view('developer.create');
    }

    public function store(DeveloperRequest $request)
    {
        $inputs = $request->validated();

        if (str_contains($inputs['logo'], 'Temps')) {
            $inputs['logo'] = $this->moveFileFromTempAndGetName($inputs['logo'], Developer::class);
        }
        if (str_contains($inputs['cover_photo'], 'Temps')) {
            $inputs['cover_photo'] = $this->moveFileFromTempAndGetName($inputs['cover_photo'], Developer::class);
        }

        Developer::create($inputs);

        return response()->json('developer created successfully', Response::HTTP_CREATED);
    }

    public function show()
    {
    }

    public function edit(developer $developer)
    {
        return view('developer.edit', compact('developer'));
    }

    public function update(DeveloperRequest $request, developer $developer)
    {
        $inputs = $request->validated();

        if ($developer->logo != $inputs['logo']) $this->deleteFile($developer->logo);

        if (str_contains($inputs['logo'], 'Temps'))
            $inputs['logo'] = $this->moveFileFromTempAndGetName($inputs['logo'], Developer::class);

        if ($developer->cover_photo != $inputs['cover_photo']) $this->deleteFile($developer->cover_photo);

        if (str_contains($inputs['cover_photo'], 'Temps'))
            $inputs['cover_photo'] = $this->moveFileFromTempAndGetName($inputs['cover_photo'], Developer::class);
    
        $developer->update($inputs);

        return response()->json('developer updated successfully', Response::HTTP_NO_CONTENT);
    }

    public function destroy(developer $developer)
    {
        $this->deleteFile($developer->logo);

        $developer->delete();

        return redirect()->back()->with('success', 'Developer deleted successfully');
    }

    public function getProjectsByDeveloper(Request $request)
    {
        $request->validate([
            'developers' => 'required|array|min:1'
        ]);

        $projects = Project::selectRaw('id as value, name as label')->whereIn('developer_id', $request->developers)->get();
        
        return response()->json($projects, 200);
    }

    public function dashboardProject()
    {
       
        $projects = Developer::where('is_active', true)
                                ->withCount('projects')
                                ->whereHas('projects')
                                ->count();

        $cameras = Project::where('is_active', true)
                                ->withCount('cameras')
                                ->whereHas('cameras')
                                ->count();
       
        return view('dashboard', compact('projects', 'cameras'));
    }
}
