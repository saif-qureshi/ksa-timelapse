<?php

namespace App\Http\Controllers;

use App\Jobs\CreateTimelapseVideo;
use App\Models\Camera;
use App\Rules\MaxDateForVideo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VideoController extends Controller
{

    public function index(Camera $camera, Request $request)
    {
        $videos = $camera->videos()
            ->whereDate('start_date', '>=', $request->start_date)
            ->whereDate('end_date', '<=', $request->end_date)
            ->get();

        return response()->json($videos);
    }

    public function store(Camera $camera, Request $request)
    {
        $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
        ]);

        $startDate = $request->date('start_date');
        $endDate = $request->date('end_date');

        if ($endDate->diffInMonths($startDate) > 4) {
            throw ValidationException::withMessages([
                'date_range' => 'Sorry, you cannot generate video for more than 4 months'
            ]);
        }

        $photos = $camera->photos()
            ->select('image')
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->latest()
            ->get()
            ->toArray();

        if (count($photos) <= 0) {
            throw ValidationException::withMessages(['photos' => 'The camera does not contain enough photos for timelapse']);
        }

        $video = $camera->videos()->create([
            'user_id' => auth()->id(),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);

        CreateTimelapseVideo::dispatch($video, $photos);

        return response()->json('Timelapse is being generate');
    }
}
