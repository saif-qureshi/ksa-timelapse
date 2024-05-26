<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use App\Models\Photo;
use App\Traits\FileHelper;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    use FileHelper;

    public function index(Request $request, Camera $camera)
    {
        $photos = $camera->photos()
            ->when($request->has('range') && $request->range, function ($query) use ($request) {
                return $query->whereBetween('created_at', [
                    $request->has('start_date') ? $request->date('start_date') : now()->startOf('month'),
                    $request->has('end_date') ? $request->date('end_date') : now()->endOf('month'),
                ]);
            })
            ->when(!$request->has('range'), function ($query) use ($request) {
                return $query->whereDate('created_at', $request->date ?? now()->format('Y-m-d'));
            })
            ->latest()
            ->get();

        $response = [
            'photos' => $photos,
        ];

        if ($request->has('date')) {
            $response['dates'] = $this->getDatesWithoutData($camera);
        }

        return response()->json($response);
    }

    public function delete(Camera $camera, Photo $photo)
    {
        $this->deleteFile($photo->image);

        $photo->delete();

        return response()->json('Photo deleted successfully', 200);
    }

    public function getDatesWithoutData(Camera $camera)
    {
        $requestedDate = request()->date('date');

        $startDate = $requestedDate->copy()->startOfMonth();
        $endDate = $requestedDate->copy()->endOfMonth();

        $datesInRange = collect([]);
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $datesInRange->push($date->format('Y-m-d'));
        }

        $datesWithData = $camera->photos()
            ->selectRaw('date(created_at) as date')
            ->whereBetween('created_at', [request()->date('date')->startOfMonth(), request()->date('date')->endOfMonth()])
            ->distinct()
            ->get()
            ->pluck('date');

        $datesWithoutData = $datesInRange->diff($datesWithData)->values()->toArray();

        return $datesWithoutData;
    }
}
