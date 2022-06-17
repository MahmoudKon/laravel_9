<?php

use App\Models\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 *  assetHelper
 *  To return the file path in public folder
 */
function assetHelper(string $path) :string
{
    return asset("app-assets/backend/$path");
}

/**
 *  routeHelper
 *  To return the route after route prefix [dashboard/]
 */
function routeHelper(string|null $route, object|array|string|int|null $options = null) :string
{
    if (! $route || $route == '#') return '';
    $route = ROUTE_PREFIX."$route";
    return route(trim($route, '.'), $options);
}

/**
 *  getModelSlug
 *  get the model class from prameter url like when make edit in model
 */
function getModelSlug(string $model_name, bool $return_id = false) :string
{
    $row = null;
    $model_name = str_replace(['{', '}'], ['', ''], $model_name);
    $id = request()->route($model_name);
    if ($return_id) return $id;
    foreach (scandir(app_path() . "/Models") as $class) {
        $class = str_replace('.php', '', $class);
        if (in_array($class, ['.', '..']) || ucfirst($model_name) != $class) continue;

        $model = app("App\Models\\$class");
        $row = $model->where('id', $id)->first();
    }

    return $row ? (method_exists($row, 'slug') ? $row->slug() : $id) : $id;
}

/**
 *  convertUrlToArray
 *  Get current url and convert it to array
 */
function convertUrlToArray() :array
{
    $routes = request()->route()->uri;
    $routes = str_replace(app()->getLocale().'/', '', $routes);
    return explode('/', $routes);
}

/**
 *  getModel
 *  Get the model from url like [users => user] and the parameter for make it singular or plural
 */
function getModel(bool $singular = false) :string
{
    try {
        // get the full controller namespace form route.
        $controller = request()->route()->action['controller'];
        // remove the method from controller namespace [UserController@index   => UserController]
        $controller = explode('@', $controller)[0];
        // usering full namsepace get the controller class
        $controller_class = app($controller);
        // in each controller has method [getModel] to get the model name.
        $model = $controller_class->getModelName(true, true);
    } catch (Exception $e) {
        $route = request()->route()->uri;
        $route = str_replace(app()->getLocale().'/', '', $route);
        $route = str_replace('dashboard/', '', $route);

        $model = explode('/', $route)[0] ?? "dashboard";
    }
    $model = str_replace(' ', '_', $model);

    return $singular ? Str::singular($model) : $model;
}

/**
 *  active
 *  Check if the current url have the value of model parameter to make the link in menu active or not
 */
function activeMenu(string|null $menu_route, $func = null, string $active_class = 'active') :bool|string // ! NOT WORKING
{
    return false;
    // remove ROUTE_PREFIX from comming route name [ROUTE_PREFIX = 'dashboard.'] => ex [dashboard.users.index => users.index]
    $menu_route = str_replace(ROUTE_PREFIX, '', $menu_route);

    // add prefix again because all menu_route not has this perfix
    $menu_route = ROUTE_PREFIX.$menu_route;

    // check if current request route is the same of menu route to make active menue
    if (request()->route()->action['as'] == $menu_route)  return $active_class;

    // else => get the comming route form database
    $route = Route::where('route', $menu_route)->first();

    // if route not exists  in database or the request route not has controller in his action return false
    if (! $route || ! isset(request()->route()->action['controller']))  return false;

    // get controller namespace for coming route
    $menu_route_controller = "$route->namespace\\$route->controller";

    // get controller namespace for request route
    $request_route_controller = explode('@', request()->route()->action['controller']);

    // check of the coming controller is the same for request controller
    return $menu_route_controller == $request_route_controller[0] && $request_route_controller[1] == $func
                ? $active_class
                : false;
}

/**
 *  canUser
 *  Check the auth user is super admin to can do any action or check if has permission to do this action
 */
function canUser($permission) :bool
{
    return auth()->user()->hasRole("super admin")
            || in_array($permission, auth()->user()->getAllPermissions()->pluck('name')->toArray())
            ? true : false;
}

function setting(string $key, $default = null)
{
    return \App\Models\Setting::where('key', $key)->first()->value ?? $default;
}

function timeReFormatting($time, $format = 'H:i:s', $included_date = false)
{
    $date = $included_date ? $time : date('Y-m-d'). " $time";
    return $time ? Carbon::parse($date)->format($format) : '';
}


function userHasPermission($user_id, $permission_id)
{
   return DB::table('task_user_permissions')->where(['user_id' => $user_id, 'task_permission_id' => $permission_id])->count();
}
