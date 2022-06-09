<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\Route;
use Closure;
use Illuminate\Http\Request;

class CheckMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get instance on user model
        $auth_user = auth()->user();

        // To check auth user is has specific roles, this roles can access to this page without conditions.
        if (!auth()->check() || $auth_user->hasRole(SUPERADMIN_ROLES)) return $next($request);

        // get the route object
        $route = request()->route();

        // route details
        $action = $route->getAction();

        $menu = Menu::where('route', str_replace(ROUTE_PREFIX, '', $action['as']))->first();

        if ($menu && ! $menu->visible) abort(404, 'This page is closed because it is under maintenance!');

        // controller namespace with his method
        $full_controller_path = explode('@', $action['controller']);

        // the only namespace
        $namespace = $action['namespace'];

        // get the only controller name
        $controller = trim(str_replace($namespace, '', $full_controller_path[0]), '\\');

        // get controller method name
        $function = $full_controller_path[1] ?? '';

        // get route methods in string
        $method = implode(',', $route->methods);

        // get route prefix
        $prefix = $action['prefix'];

        // get url without prefix
        $uri = str_replace($prefix, 'dashboard', $route->uri);

        // get the route from database
        // en/dashboard/users
        $route = Route::where([
            'uri'        => $uri, // dashboard/users
            'method'     => $method, // get
            'controller' => $controller, // UserController
            'func'       => $function // index
        ])->first();

        // if current route not exists in database, return 404 page not found
        if (!$route) {
            if ($request->ajax()) return response()->json(['message' => 'This route not saved in database!', 'title' => 'ROLES'], 403);
            abort(403, 'This route not saved in database!');
        }

        if ($auth_user->hasPermissionTo($route->permissionName())) return $next($request);

        // get all user roles id in array
        $roles_id = $auth_user->roles()->pluck('id')->toArray();

        // get the count of rows for the current route with user roles
        $count = $route->roles()->whereIn('role_id', $roles_id)->count();

        // check count not equal 0 then return the next page.
        if ($count) return $next($request);

        // here the user not have permissions to access this page
        if ($request->ajax()) return response()->json(['message' => 'You do not have permission to access this page!', 'title' => 'ROLES'], 403);
        abort(403, 'You do not have permission to access this page!');
    }
}
