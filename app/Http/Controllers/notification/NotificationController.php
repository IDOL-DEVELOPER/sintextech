<?php

namespace App\Http\Controllers\notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    public function view()
    {
        session()->put('referring_route', request()->route()->getName());
        return view('admin.notification.view');
    }

    public function getNotifications()
    {
        $notifications = user()->notifications()->whereNull('read_at')->take(5)->get();
        return response()->json([
            'notifications' => $notifications,
            'has_notifications' => $notifications->isNotEmpty()
        ]);
    }

}
