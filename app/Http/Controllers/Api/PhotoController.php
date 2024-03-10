<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PhotoRequest;
use App\Models\Camera;
use App\Models\Photo;
use App\Traits\FileHelper;

class PhotoController extends Controller
{
    use FileHelper;

    public function store(PhotoRequest $request)
    {
        $token = $request->header('X-Cam-Auth');

        $camera = Camera::where('access_token', $token)->first();

        $camera->photos()->create([
            'image' => $this->saveFileAndGetName($request->file('image'), Photo::class)
        ]);

        return response()->json('Photo uploaded successfully', 200);
    }
}
