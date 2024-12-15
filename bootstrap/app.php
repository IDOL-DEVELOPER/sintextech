<?php

use App\Http\Middleware\PermissionCheck;
use App\Http\Middleware\PermissionManager;
use App\Http\Middleware\RtPermission;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "permission" => PermissionCheck::class,
            "rtpermission" => RtPermission::class,
            "permissionmanager" => PermissionManager::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
