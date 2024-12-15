<?php
use App\Http\Controllers\Upload\UploadController;
use Illuminate\Support\Facades\Route;


Route::prefix('/upload')->group(function () {
    Route::controller(UploadController::class)->group(function () {
        Route::get('', 'view')->name("upload.view")->middleware(['permission:read']);
        Route::post('action', 'action')->name("upload.action");
    });
});


