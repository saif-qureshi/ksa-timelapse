<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use App\Models\Photo;
use App\Traits\FileHelper;
use Carbon\Carbon;
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
            ->when($request->has('range') && $request->range, fn($query) => $query->whereRangeIn($startDate, $endDate))
            ->when(!$request->has('range'), fn($query) => $query->whereDateIn($date))
            ->orderBy('created_at', 'desc')
            ->get();
            
        $response = [
            'photos' => $photos,
        ];

        if ($request->has('date')) {
            $response['dates'] = $this->getDatesWithoutData($date, $camera);
        }

        return response()->json($response);
    }

    public function delete(Camera $camera, Photo $photo)
    {
        $this->deleteFile($photo->image);

        $photo->delete();

        return response()->json('Photo deleted successfully', 200);
    }

    public function getDatesWithoutData(Carbon $date, Camera $camera)
    {
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        $datesInRange = collect([]);

        for ($currentDate = $startDate->copy(); $currentDate->lte($endDate); $currentDate->addDay()) {
            $datesInRange->push($currentDate->format('Y-m-d'));
        }

        $datesWithData = $camera->photos()
            ->selectRaw('created_at')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->distinct()
            ->get()
            ->pluck('created_at')
            ->map(function ($createdAt) use ($camera) {
                return Carbon::parse($createdAt, 'UTC')
                    ->setTimezone($camera->timezone)
                    ->format('Y-m-d');
            })
            ->unique()
            ->values();
        $datesWithoutData = $datesInRange->diff($datesWithData)->values()->toArray();

        return $datesWithoutData;
    }
}
