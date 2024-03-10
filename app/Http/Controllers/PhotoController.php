<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(Request $request, Camera $camera)
    {
        $photos = $camera->photos()
            ->whereDate('created_at', $request->date ?? now()->format('Y-m-d'))
            ->latest()
            ->get();

        return response()->json($photos);
    }
}
