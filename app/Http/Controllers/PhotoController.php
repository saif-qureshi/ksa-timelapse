<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(Request $request, Camera $camera)
    {
        $photos = $camera->photos()
            ->when($request->has('range') && $request->range, function($query) use($request){
                return $query->whereBetween('created_at',[
                    $request->has('start_date') ? $request->date('start_date') : now()->startOf('month'),
                    $request->has('end_date') ? $request->date('end_date') : now()->endOf('month'),
                ]);
            })
            ->when(!$request->has('range'), function ($query) use($request) {
                return $query->whereDate('created_at', $request->date ?? now()->format('Y-m-d'));
            })
            ->latest()
            ->get();

        return response()->json($photos);
    }
}
