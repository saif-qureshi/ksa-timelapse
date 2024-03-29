<?php

namespace App\Http\Controllers;

use App\Jobs\CreateTimelapseVideo;
use App\Models\Camera;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $startDate = now()->format('Y-m-d');
        $endDate = now()->addDay()->format('Y-m-d');
        $camera = Camera::inRandomOrder()->first();
        CreateTimelapseVideo::dispatch($camera, $startDate, $endDate);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        //
    }
}
