<?php

namespace App\Trait;

use App\Models\Permissions;

trait Permission
{
    public function permissions()
    {
        return $this->hasMany(Permissions::class, 'uid');
    }
    public function hasPermission(...$permissions)
    {
        if (check() && user()->dflt == true) {
            return true;
        }
        $routeName = \Route::currentRouteName(); // Get current route name
        $sessionRouteName = session()->get('referring_route'); // Get route name from session
        $hasPermissionFromSession = false;

        if ($sessionRouteName) {
            // Check permissions based on session route name
            $hasPermissionFromSession = $this->checkRoutePermissions($sessionRouteName, ...$permissions);
        }
        // Check permissions based on current route name if not already granted via session
        if (!$hasPermissionFromSession) {
            $hasPermissionFromCurrentRoute = $this->checkRoutePermissions($routeName, ...$permissions);
            // if ($hasPermissionFromCurrentRoute) {
            //     return true;
            // }
        }
        return $hasPermissionFromSession || $hasPermissionFromCurrentRoute;
    }
    private function checkRoutePermissions($routes, ...$permissions)
    {
        if (!$routes) {
            return false;
        }
        $routes = is_array($routes) ? $routes : [$routes];
        $permissions = is_array($permissions) ? $permissions : [$permissions];
        foreach ($routes as $routeName) {
            // Check permissions for menus
            $hasMenuPermission = $this->permissions()
                ->where('user_type', $this->instance())
                ->whereHas('menus', function ($query) use ($routeName) {
                    $query->where('route', $routeName);
                })
                ->latest('created_at')
                ->first();

            if ($hasMenuPermission) {
                foreach ($permissions as $permission) {
                    if ($hasMenuPermission->$permission) {
                        return true; // Return true if any permission matches for this route
                    }
                }
            }

            // Check permissions for submenus
            $hasSubmenuPermission = $this->permissions()
                ->where('user_type', $this->instance())
                ->whereHas('submenu', function ($query) use ($routeName) {
                    $query->where('route', $routeName);
                })
                ->latest('created_at')
                ->first();

            if ($hasSubmenuPermission) {
                foreach ($permissions as $permission) {
                    if ($hasSubmenuPermission->$permission) {
                        return true; // Return true if any permission matches for this route
                    }
                }
            }
        }

        return false; // 
    }
    public function checkPermissionWithRoute(...$args)
    {
        // Separate permissions and routes from arguments
        $permissions = array_filter($args, fn($arg) => is_string($arg) && !is_array($arg));
        $routes = array_filter($args, fn($arg) => is_array($arg) || (is_string($arg) && strpos($arg, '.')));
        return $this->checkRoutePermissions(...$routes, ...$permissions);
    }
}
