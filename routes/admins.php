<?php
use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('/maganers')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('', 'view')->name("admin.admins")->middleware(['permission:read']);
        Route::post('', 'action')->name("admin.adminsAction");
        Route::get('permissions/{id?}', 'permissioView')->name("admin.adminPermissionView")->middleware('permissionmanager:admin.admins');
    });
});
