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

        $startDate = $request->date('start_date')->setTime(8, 0, 0);
        $endDate = $request->date('end_date')->setTime(17, 0, 0);

        $videos = $camera->videos()
            ->whereDate('start_date', '>=', $startDate)
            ->orWhereDate('end_date', '<=', $endDate)
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

        $startDate = $request->date('start_date')->setTimezone($camera->timezone ?? 'Asia/Dubai')->setTime(8, 0, 0);
        $endDate = $request->date('end_date')->setTimezone($camera->timezone ?? 'Asia/Dubai')->setTime(17, 0, 0);

        if ($endDate->diffInMonths($startDate) > 4) {
            throw ValidationException::withMessages([
                'date_range' => 'Sorry, you cannot generate video for more than 4 months'
            ]);
        }

        $startTimeInUTC = $startDate->clone()->setTimezone('UTC')->format('H:i:s');
        $endTimeInUTC = $endDate->clone()->setTimezone('UTC')->format('H:i:s');


        $photos = $camera->photos()
            ->select('image')
            ->whereBetween('created_at', [
                $startDate->setTimezone('UTC')->toDateTimeString(),
                $endDate->setTimezone('UTC')->toDateTimeString()
            ])
            ->whereTime('created_at', '>=', $startTimeInUTC)
            ->whereTime('created_at', '<=', $endTimeInUTC)
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
