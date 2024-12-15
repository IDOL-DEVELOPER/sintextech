<?php
namespace App\Http\Middleware;

use App\Models\Permissions;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionCheck
{
    public function handle(Request $request, Closure $next, $action)
    {
        $user = user();
        if (user()->dflt == true && user()->instance() == 'admin') {
            return $next($request);
        }
        if (!$user) {
            abort(401);
        }
        $routeName = $request->route()->getName();
        // Check permissions for submenu
        $submenuPermission = Permissions::where('uid', $user->id)
            ->where('user_type', user()->instance())
            ->whereHas('submenu', function ($query) use ($routeName) {
                $query->where('route', $routeName);
            })
            ->latest('created_at')
            ->first();
        if ($submenuPermission && $submenuPermission->$action) {
            $menuPermission = $submenuPermission->submenu()
                ->latest('created_at')
                ->first();
            $menuPermission = $submenuPermission->submenu->menu->permissions()
                ->where('user_type', user()->instance())
                ->latest('created_at')
                ->first();
            if ($menuPermission && $menuPermission->$action) {
                return $next($request);
            }
        }
        $menuPermission = Permissions::where('uid', $user->id)
            ->where('user_type', user()->instance())
            ->whereHas('menus', function ($query) use ($routeName) {
                $query->where('route', $routeName);
            })
            ->latest('created_at')
            ->first();
        if ($menuPermission && $menuPermission->$action) {
            return $next($request);
        }
        if (!$submenuPermission && !$menuPermission) {
            return $next($request);
        }
        abort(403);
    }
}
