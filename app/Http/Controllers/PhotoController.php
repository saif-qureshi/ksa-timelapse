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
        $startDate = $request->date('start_date', tz: $camera->timezone) ?? now()->startOf('month');
        $endDate = $request->date('end_date', tz: $camera->timezone) ?? now()->endOf('month');
        $date = $request->date('date', tz: $camera->timezone) ?? now($camera->timezone);

        $photos = $camera->photos()
            ->when($request->has('range') && $request->range, fn ($query) => $query->whereRangeIn($startDate, $endDate))
            ->when(!$request->has('range'), fn ($query) => $query->whereDateIn($date))
            ->orderBy('created_at', 'desc')
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
