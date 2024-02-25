<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::resource('user', UserController::class);
    Route::post('developer/project', [DeveloperController::class, 'getProjectsByDeveloper']);
    Route::resource('developer', DeveloperController::class);
    Route::resource('project', ProjectController::class);

    Route::group(['prefix' => 'image', 'as' => 'image.'], static function () {
        Route::get('/fetch', [FileUploadController::class, 'fetchGallery'])->name('gallery.fetch');
        Route::post('/upload', [FileUploadController::class, 'storeGallery'])->name('gallery.upload');
        Route::delete('/delete', [FileUploadController::class, 'removeGallery'])->name('gallery.remove');
        Route::post('/download', [FileUploadController::class, 'downloadImage']);
    });
});
