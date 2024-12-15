<?php

use App\Http\Controllers\pages\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('/pages')->group(function () {
    Route::controller(PageController::class)->group(function () {
        Route::get('', 'view')->name("admin.pages")->middleware(['permission:read']);
        Route::get('/create-update/{slug?}', 'form')->name("admin.pagesForm")->middleware(['rtpermission:admin.pages']);
        Route::post('', 'action')->name("admin.pagesAction");
    });
});


