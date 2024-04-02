<?php

use App\Jobs\CreateTimelapseVideo;
use App\Models\Camera;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('/test',function() {
// $camera = Camera::find(1);
// $photos = $camera->photos()
//         ->select('image')
//         ->whereBetween('created_at', ['2024-02-01', '2024-03-31'])
//         ->latest()
//         ->get()
//         ->toArray();
// CreateTimelapseVideo::dispatch($camera, $photos);
});

Auth::routes();
