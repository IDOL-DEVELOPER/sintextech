<?php

use App\Http\Controllers\menus\MenuController;
use Illuminate\Support\Facades\Route;


Route::prefix('/menus')->group(function () {
    Route::controller(MenuController::class)->group(function () {
        Route::get('', 'view')->name("admin.menus");
    });

});


