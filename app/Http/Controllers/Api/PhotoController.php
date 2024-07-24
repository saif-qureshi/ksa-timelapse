<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PhotoRequest;
use App\Models\Camera;
use App\Models\Photo;
use App\Traits\FileHelper;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    use FileHelper;

    public function store(PhotoRequest $request)
    {
        Log::info('Photo started uploading .' . now()->setTimezone('Asia/Karachi')->toDateTimeString());

        $token = $request->header('X-Cam-Auth');

        $camera = Camera::where('access_token', $token)->first();

        $file = $request->file('image');

        $camera->photos()->create([
            'image' => $request->file('image')->store('photos'),
            'created_at' => $this->extractDateTimeFromFilename($file, $camera->timezone ?? 'UTC'),
            'updated_at' => $this->extractDateTimeFromFilename($file, $camera->timezone ?? 'UTC'),
        ]);

        Log::info('Photo uploaded successfully .' . now()->setTimezone('Asia/Karachi')->toDateTimeString());

        return response()->json('Photo uploaded successfully', 200);
    }

    protected function extractDateTimeFromFilename(UploadedFile $file, $timezone)
    {
        $pattern = '/(\d{14})\.(jpg|jpeg|png)/';

        $filename = $file->getClientOriginalName();

        if (preg_match($pattern, $filename, $matches)) {
            $dateTimeString = $matches[1];

            $dateTime = Carbon::createFromFormat('YmdHis', $dateTimeString, $timezone);
            if($timezone == 'UTC') return $dateTime;
            $dateTime = Carbon::createFromFormat('YmdHis', $dateTimeString, $timezone)->setTimezone('UTC');

            return $dateTime;
        }

        return Carbon::now();
    }
}
