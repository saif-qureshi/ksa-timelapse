<?php

namespace App\Http\Controllers;

use App\Jobs\CreateTimelapseVideo;
use App\Models\Camera;
use App\Models\Video;
use App\Traits\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VideoController extends Controller
{
    use FileHelper;

    public function index(Camera $camera, Request $request)
    {
        $videos = $camera->videos()
            ->whereDate('start_date', '>=', $request->start_date)
            ->orWhereDate('end_date', '<=', $request->end_date)
            ->where('status', 'completed')
            ->latest()
            ->get();

        return response()->json($videos);
    }

    public function store(Camera $camera, Request $request)
    {
        abort_if(!auth()->user()->can_create_user, 403, 'Access denied');

        $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
        ]);

        $startDate = $request->date('start_date')->hour(8)->minute(0)->second(0);
        $endDate = $request->date('end_date')->hour(5)->minute(0)->second(0);

        if ($endDate->diffInMonths($startDate) > 4) {
            throw ValidationException::withMessages([
                'date_range' => 'Sorry, you cannot generate video for more than 4 months'
            ]);
        }

        $photos = $camera->photos()
            ->select('image')
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->whe
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

    public function destroy(Camera $camera, Video $video)
    {
        $this->deleteFile($video->file);

        $video->delete();

        return response()->json('Video deleted successfully');
    }
}
