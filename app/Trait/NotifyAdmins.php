<?php

namespace App\Trait;

use App\Models\Admin;
use App\Notifications\GenericNotification;

trait NotifyAdmins
{
    public function notifyAdmin($data = null)
    {
        $data = array_merge($data ?? [], [
            'action_at' => now(),
            'action_by' => user()->name ?? 'N/A',
            'instance' => user()->instance() ?? 'Admin',
        ]);

        $admins = Admin::where('dflt', true)->get();
        foreach ($admins as $admin) {
            $admin->notify(new GenericNotification($data));
        }
        return true;
    }

}
