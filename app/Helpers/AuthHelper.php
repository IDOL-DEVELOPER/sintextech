<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

function user()
{
    foreach (config('auth.guards') as $guardName => $guardConfig) {
        if ($user = Auth::guard($guardName)->user()) {
            return $user;
        }
    }
    return null;
}
function check()
{
    foreach (config('auth.guards') as $guardName => $guardConfig) {
        if ($user = Auth::guard($guardName)->check()) {
            return true;
        }
    }
    return false;
}


