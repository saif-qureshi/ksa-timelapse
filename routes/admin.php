<?php

use App\Http\Controllers\CameraController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\{
    CommentController,
    DashboardController,
    VideoController
};
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('user', UserController::class);
    Route::post('developer/project', [DeveloperController::class, 'getProjectsByDeveloper']);
    Route::resource('developer', DeveloperController::class);
    Route::resource('project', ProjectController::class);

    Route::group(['prefix' => 'camera/{camera}'], function () {
        Route::get('/refresh-token', [CameraController::class, 'refreshToken'])->name('camera.refresh-token');
        Route::post('/photos', [PhotoController::class, 'index'])->name('photos');
        Route::resource('videos', VideoController::class)->only(['index', 'store', 'destroy']);
    });

    Route::resource('camera', CameraController::class);
    Route::resource('comments', CommentController::class);

    Route::group(['prefix' => 'home'], function () {
        Route::get('/', [HomeController::class, 'developers'])->name('home.developers');
        Route::get('/{developer}/projects', [HomeController::class, 'projects'])->name('home.developer');
        Route::get('/{project}/cameras', [HomeController::class, 'cameras'])->name('home.project');
    });

    Route::group(['prefix' => 'image', 'as' => 'image.'], static function () {
        Route::get('/fetch', [FileUploadController::class, 'fetchGallery'])->name('gallery.fetch');
        Route::post('/upload', [FileUploadController::class, 'storeGallery'])->name('gallery.upload');
        Route::delete('/delete', [FileUploadController::class, 'removeGallery'])->name('gallery.remove');
        Route::post('/download', [FileUploadController::class, 'downloadImage']);
    });
});
