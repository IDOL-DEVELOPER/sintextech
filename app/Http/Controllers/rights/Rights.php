<?php

namespace App\Http\Controllers\rights;

use App\Http\Controllers\Controller;
use App\Models\Menus;
use App\Models\PermissionMap;
use App\Models\Permissions;
use Illuminate\Http\Request;

class Rights extends Controller
{
    public function view()
    {
        $menus = Menus::where('dflt', false)
            ->orderBy('order')
            ->get();
        $permissionMap = PermissionMap::all();
        return view("admin.rights.view", compact('menus', 'permissionMap'));
    }
    public function permissions(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'type' => 'required|string',
                'id' => 'required|string',
                'checked' => 'required|boolean',
                'menu' => 'required|string',
                'uid' => 'required|string',
                'instance' => 'required|string',
            ]);

            $type = $validatedData['type'];
            $id = $validatedData['id'];
            $checked = $validatedData['checked'];
            $menu = $validatedData['menu'];
            $uid = $validatedData['uid'];
            $instance = $validatedData['instance'];

            if (user()->id == $uid && user()->instance() == $instance) {
                ce("unauthorized access to own user id for permission");
                return response()->json(["error" => true, "message" => "Unauthorized Access"]);
            }

            $query = Permissions::where('uid', $uid)
                ->where('user_type', $instance);

            if ($menu === 'mid') {
                $query->where('mid', $id);
            } elseif ($menu === 'subid') {
                $query->where('subid', $id);
            }

            $permission = $query->first();

            if ($permission) {
                $permission->{$type} = $checked;
                $permission->save();
            } else {
                $newPermission = new Permissions();
                $newPermission->uid = $uid;
                $newPermission->user_type = $instance;
                if ($menu === 'mid') {
                    $newPermission->mid = $id;
                } elseif ($menu === 'subid') {
                    $newPermission->subid = $id;
                }
                $newPermission->{$type} = $checked;
                $newPermission->save();
            }

            return response()->json(["error" => false, "message" => "success"]);
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(["error" => true, "message" => $th->getMessage()]);
        }
    }

}
