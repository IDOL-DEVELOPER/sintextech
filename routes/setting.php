<?php
use App\Http\Controllers\setting\SettingController;
use Illuminate\Support\Facades\Route;


Route::prefix('/setting')->group(function () {
    Route::controller(SettingController::class)->group(function () {
        Route::get('', 'view')->name("admin.setting")->middleware(['permission:read']);
        Route::post('', 'action')->name("admin.settingAction");
    });
});


