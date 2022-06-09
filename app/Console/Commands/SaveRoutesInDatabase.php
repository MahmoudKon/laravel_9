<?php

namespace App\Console\Commands;

use App\Models\Route;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Spatie\Permission\Models\Permission;

class SaveRoutesInDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get all routes in project and store it in table with creating permissions for each route';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (FacadesRoute::getRoutes()->getRoutes() as $route)
        {
            $action = $route->getAction();
            if ( isset($action['controller']) && ( stripos($action['controller'], 'App\Http\Controllers\Backend') !== false) ) {
                $full_controller_path = explode('@', $action['controller']);

                $namespace = $action['namespace'];
                $controller = trim(str_replace($namespace, '', $full_controller_path[0]), '\\');
                $function = $full_controller_path[1];
                $method = implode(',', $route->methods);
                $middleware = implode(',', $action['middleware']);
                $route_name = $action['as'] ?? "";
                $prefix = $action['prefix'];
                $uri = str_replace($prefix, 'dashboard/', $route->uri);
                $where = implode(',', $action['where']);

                $route = Route::firstOrCreate([
                    'controller' => $controller,
                    'func'       => $function,
                    'method'     => $method,
                    'uri'        => $uri,
                ], [
                    'controller' => $controller,
                    'func'       => $function,
                    'method'     => $method,
                    'middleware' => $middleware,
                    'namespace'  => $namespace,
                    'uri'        => $uri,
                    'route'      => $route_name,
                    'prefix'     => $prefix,
                    'where'      => $where
                ]);

                Permission::firstOrCreate(['name' => $route->permissionName(), 'guard_name' => 'web']);
            }
        }
        echo "Routes Saved Successfully! \r\n";
    }
}
