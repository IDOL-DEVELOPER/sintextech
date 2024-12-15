<?php
use App\Http\Controllers\admin\AccountController;
use Illuminate\Support\Facades\Route;


Route::prefix('/account')->group(function () {
    Route::controller(AccountController::class)->group(function () {
        Route::get('', 'view')->name("admin.account");
        Route::post('/update', 'updateAccount')->name("admin.updateAccount");
        Route::post('/fetch', 'fetchImage')->name("admin.fetchImage");
        Route::post('/password/update', 'updatePassword')->name("admin.updatePassword");
        Route::post('/save/Image', 'saveImage')->name("admin.saveImage");
    });
    
});


