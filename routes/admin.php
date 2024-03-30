<?php

use App\Http\Controllers\CameraController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\{
    CommentController
};
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DeveloperController::class, 'dashboardProject'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::post('developer/project', [DeveloperController::class, 'getProjectsByDeveloper']);
    Route::resource('developer', DeveloperController::class);
    Route::resource('project', ProjectController::class);
    Route::get('camera/{camera}/refresh-token', [CameraController::class, 'refreshToken'])->name('camera.refresh-token');
    Route::resource('camera', CameraController::class);

    Route::get('camera/{camera}/photos',[PhotoController::class,'index'])->name('photos');
    Route::resource('comments', CommentController::class);

    Route::get('home', [HomeController::class, 'developers'])->name('home.developers');
    Route::get('home/{developer}/projects', [HomeController::class, 'projects'])->name('home.developer');
    Route::get('home/{project}/cameras', [HomeController::class, 'cameras'])->name('home.project');

    Route::group(['prefix' => 'image', 'as' => 'image.'], static function () {
        Route::get('/fetch', [FileUploadController::class, 'fetchGallery'])->name('gallery.fetch');
        Route::post('/upload', [FileUploadController::class, 'storeGallery'])->name('gallery.upload');
        Route::delete('/delete', [FileUploadController::class, 'removeGallery'])->name('gallery.remove');
        Route::post('/download', [FileUploadController::class, 'downloadImage']);
    });
});
