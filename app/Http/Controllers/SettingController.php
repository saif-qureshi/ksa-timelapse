<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use FileHelper;

    public function index()
    {
        $settings = settings();
        
        return view('settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $settings = $request->except('_token');

        foreach ($settings as $key => $value) {
            $value = $this->resolveValue($key, $value);
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget('settings');

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function resolveValue($key, $value)
    {
        if (str_contains($value, 'Temps/')) {
            $exists = Storage::exists($value);
            if ($exists) {
                $oldValue = settings($key);
                if ($oldValue !== $value) {
                    $this->deleteFile($oldValue);
                }
                return $this->moveFileFromTempAndGetName($value, Setting::class);
            }
        }
        return $value;
    }
}
