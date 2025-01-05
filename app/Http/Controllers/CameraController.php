<?php

namespace App\Http\Controllers;

use App\Http\Requests\CameraRequest;
use App\Models\Camera;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CameraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('camera.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $timezones = collect(Camera::TIMEZONES);

        $developers = Developer::selectRaw('id as value, name as label')->where('is_active', true)->get();

        return view('camera.create', compact('developers', 'timezones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CameraRequest $request)
    {
        $inputs = $request->validated();

        Camera::create($inputs);

        return response()->json('project created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Camera $camera)
    {
        $recent = $camera->photos()->orderBy('created_at', 'desc')->first();

        return view('camera.show')->with([
            'camera' => $camera,
            'last_captured_at' => $recent ? $recent->created_at->toDateString() : now()->toDateString(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Camera $camera)
    {
        $timezones = collect(Camera::TIMEZONES);

        $developers = Developer::selectRaw('id as value, name as label')->where('is_active', true)->get();

        return view('camera.edit', compact('developers', 'camera', 'timezones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CameraRequest $request, Camera $camera)
    {
        $inputs = $request->validated();

        $camera->update($inputs);

        return response()->json('project updated successfully', Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Camera $camera)
    {
        //
    }

    public function refreshToken(Camera $camera)
    {
        $camera->refreshAccessToken();

        return redirect()->back()->with('success', 'Access token regenerated');
    }
}
