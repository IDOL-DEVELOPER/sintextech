<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $routeNames)
    {
        if (check() && user()->instance() == "admin" && user()->dflt == 1) {
            return $next($request);
        }
        $referringRouteName = session()->get('referring_route');
        if (is_string($routeNames)) {
            $routeNames = explode(',', $routeNames);
        }
        if (!in_array($referringRouteName, $routeNames)) {
            return abort(403);
        }
        if (!user()->hasPermission('rights')) {
            return abort(403);
        }

        return $next($request);
    }
}
