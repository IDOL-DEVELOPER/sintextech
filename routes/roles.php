<?php
use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\admin\RoleController;
use Illuminate\Support\Facades\Route;


Route::prefix('/roles')->group(function () {
    Route::controller(RoleController::class)->group(function () {
        Route::get('', 'view')->name("admin.roles")->middleware(['permission:read']);
        Route::post('', 'action')->name("admin.rolesAction");
    });
});


