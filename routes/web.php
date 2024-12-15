<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\PasswordForgotController;
use App\Http\Controllers\dashboard\DashController;
use App\Http\Controllers\notification\NotificationController;
use App\Http\Controllers\rights\Rights;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest:admin'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'view')->name('login');
        Route::post('/login', 'login')->name('login.post');
        Route::get('login/google', 'googleLogin')->name('googlelogin');
        Route::any('login/google/callback', 'googleCallback')->name('googlecallback');
    });
    Route::controller(PasswordForgotController::class)->group(function () {
        Route::get('/password/forgot', 'view')->name('password.forgot');
        Route::post('/password/email', 'sendResetLink')->name('password.email');
        // Reset password
        Route::get('/password/reset/{token}', 'showResetForm')->name('password.reset');
        Route::post('/password/reset', 'resetPassword')->name('password.update');
    });
});
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [DashController::class, 'view'])->name("admin.dashboard");
    Route::get('logout', [AuthController::class, "logout"])->name('logout');
    Route::post('/permissions', [Rights::class, 'permissions'])->name("admin.Permissions");
    Route::get('', function () {
        // Run Artisan commands
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        return back()->with('success', 'Cache Clear Successfully');
    })->name('clear.cache');
    Route::get('/get-notifications', [NotificationController::class, 'getNotifications'])->name('get.notifications');
    Route::get('/notifications', [NotificationController::class, 'view'])->name('admin.NotificationView');
    //import other
    require base_path('routes/setting.php');
    require base_path('routes/upload.php');
    require base_path('routes/blog.php');
    require base_path('routes/account.php');
    require base_path('routes/admins.php');
    require base_path('routes/roles.php');
    require base_path('routes/locations.php');
    require base_path('routes/pages.php');
    require base_path('routes/menus.php');
});
