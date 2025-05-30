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
        $token = $request->header('X-Cam-Auth');

        $camera = Camera::where('access_token', $token)->first();

        $file = $request->file('image');
        $dateTime = $this->extractDateTimeFromFilename($file, $camera->timezone);

        Log::info('************');
        Log::info('Uploading photo :'. $file->getClientOriginalName());
        Log::info('Uploading datetime :'. $dateTime);
        Log::info('************');

        $camera->photos()->create([
            'image' => $request->file('image')->store('photos'),
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ]);

        return response()->json('Photo uploaded successfully', 200);
    }

    protected function extractDateTimeFromFilename(UploadedFile $file, $timezone)
    {
        $pattern = '/(\d{14})\.(jpg|jpeg|png)/';

        $filename = $file->getClientOriginalName();

        if (preg_match($pattern, $filename, $matches)) {
            $dateTimeString = $matches[1];
            $dateTime = Carbon::createFromFormat('YmdHis', $dateTimeString, $timezone)->setTimezone('UTC');
            return $dateTime;
        }

        return Carbon::now();
    }
}
