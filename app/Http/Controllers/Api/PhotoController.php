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
        Log::info('Photo started uploading .' . now()->setTimezone('Asia/Karachi')->toDateTimeString());

        $token = $request->header('X-Cam-Auth');

        $camera = Camera::where('access_token', $token)->first();

        $request->file('image')->store('Temps');

        $camera->photos()->create([
            'image' => $this->saveFileAndGetName($request->file('image'), Photo::class)
        ]);

        Log::info('Photo uploaded successfully .' . now()->setTimezone('Asia/Karachi')->toDateTimeString());

        return response()->json('Photo uploaded successfully', 200);
    }
}
