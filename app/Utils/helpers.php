<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

if (!function_exists('settings')) {
    function settings($key = null, $default = null)
    {
        $settings = Cache::rememberForever('settings', function () {
            return Setting::get()->pluck('value', 'key')->all();
        });
        
        if ($key !== null) {
            return Arr::get($settings, $key, $default);
        }

        return $settings;
    }
}
