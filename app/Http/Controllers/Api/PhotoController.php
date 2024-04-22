<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PhotoRequest;
use App\Models\Camera;
use App\Models\Photo;
use App\Traits\FileHelper;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    use FileHelper;

    public function store(PhotoRequest $request)
    {
        Log::info('Photo started uploading.' . now()->setTimezone('Asia/Karachi')->toDateString());

        $token = $request->header('X-Cam-Auth');

        $camera = Camera::where('access_token', $token)->first();

        $camera->photos()->create([
            'image' => $this->saveFileAndGetName($request->file('image'), Photo::class)
        ]);

        Log::info('Photo uploaded successfully.' . now()->setTimezone('Asia/Karachi')->toDateString());

        return response()->json('Photo uploaded successfully', 200);
    }
}
