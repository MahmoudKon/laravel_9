<?php

namespace App\Console\Commands;

use App\Models\Menu;
use App\Models\Route;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class GenerateClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:classes {model} {routes?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to generate model, migration, controller, request file and datatable class';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = ucfirst($this->argument('model'));

        if (file_exists("App\Models\{$model}.php")) {
            echo "model class {$model} already exists!\n";
        } else {
            Artisan::call("make:model $model");
            echo "model class {$model} created successfully!\n";
        }

        if (file_exists("App\Http\Controllers\Backend\{$model}Controller.php")) {
            echo "controller class {$model}Controller already exists!\n";
        } else {
            Artisan::call("make:controller Backend/{$model}Controller --model=$model --type=custom");
            echo "controller class {$model}Controller created successfully!\n";
        }

        if (file_exists("App\Http\Services\{$model}Service.php")) {
            echo "service class {$model}Service already exists!\n";
        } else {
            Artisan::call("make:service {$model}Service");
            echo "service class {$model}Service created successfully!\n";
        }

        Artisan::call("make:migration ".$this->getMigrationName($model));
        echo "migration class ".$this->getMigrationName($model)." created successfully!\n";

        if (file_exists("App\DataTables\{$model}DataTable.php")) {
            echo "datatable class {$model}Datatable already exists!\n";
        } else {
            Artisan::call("datatables:make $model");
            echo "datatable class {$model}Datatable created successfully!\n";
        }

        if (file_exists("App\Observers\{$model}Observer.php")) {
            echo "observe class {$model}Observer already exists!\n";
        } else {
            Artisan::call("make:observer {$model}Observer --model=$model");
            echo "observe class {$model}Observer created successfully!\n";
        }

        if (file_exists("App\Requests\{$model}Request.php")) {
            echo "request class {$model}Request already exists!\n";
        } else {
            Artisan::call("make:request ".$model."Request");
            echo "request class {$model}Request created successfully!\n";
        }

        $view_path = "backend.{$this->getPluralName($model)}.form";
        Artisan::call("make:view $view_path");
        echo "request class $view_path created successfully!\n";

        $this->createRoutes($model);
        echo "request class {$model}Request created successfully!\n";

        echo "all classes genrated successfully!\n";
    }

    protected function getMigrationName($model)
    {
        $name = $this->getPluralName($model);
        return "create_{$name}_table";
    }

    protected function getPluralName($model)
    {
        // Separate between each word by underscore
        $name = preg_replace('/([^A-Z-])([A-Z])/', '$1_$2', $model);
        // Convert string to lower case
        $name = strtolower($name);
        // Convert string to plural
        $name = Str::plural($name);
        return $name;
    }

    protected function createRoutes($model)
    {
        if (! $this->argument('routes')) return true;

        $controller   = "{$model}Controller";
        $model_pram   = strtolower($model);
        $model        = Str::plural(strtolower($model));
        $namespace    = "App\Http\Controllers\Backend";
        $middleware   = "web,localeSessionRedirect,localizationRedirect,localeViewPath,auth";
        $ROUTE_PREFIX = str_replace('.', '/', ROUTE_PREFIX);
        $prefix       = "/$ROUTE_PREFIX";

        $routes = [
            [
                'route'  => "$model.index",
                'uri'    => $ROUTE_PREFIX."$model",
                'method' => 'GET,HEAD',
                'func'   => 'index'
            ], [
                'route'  => "$model.create",
                'uri'    => $ROUTE_PREFIX."$model",
                'method' => 'GET,HEAD',
                'func'   => 'create'
            ], [
                'route'  => "$model.store",
                'uri'    => $ROUTE_PREFIX."$model",
                'method' => 'POST',
                'func'   => 'store'
            ], [
                'route'  => "$model.show",
                'uri'    => $ROUTE_PREFIX."$model/{$model_pram}",
                'method' => 'GET,HEAD',
                'func'   => 'show'
            ], [
                'route'  => "$model.edit",
                'uri'    => $ROUTE_PREFIX."$model/{$model_pram}/edit",
                'method' => 'GET,HEAD',
                'func'   => 'edit'
            ], [
                'route'  => "$model.update",
                'uri'    => $ROUTE_PREFIX."$model/{$model_pram}",
                'method' => 'PUT,PATCH',
                'func'   => 'update'
            ], [
                'route'  => "$model.destroy",
                'uri'    => $ROUTE_PREFIX."$model/{$model_pram}",
                'method' => 'DELETE',
                'func'   => 'destroy'
            ], [
                'route'  => "$model.multidelete",
                'uri'    => $ROUTE_PREFIX."$model/multidelete",
                'method' => 'POST',
                'func'   => 'multidelete'
            ],
        ];

        foreach ($routes as $route) {
            $row = Route::firstOrCreate([
                'controller' => $controller,
                'func'       => $route['func'],
                'method'     => $route['method'],
                'uri'        => $route['uri'],
            ], [
                'controller' => $controller,
                'func'       => $route['func'],
                'method'     => $route['method'],
                'middleware' => $middleware,
                'namespace'  => $namespace,
                'uri'        => $route['uri'],
                'route'      => $route['route'],
                'prefix'     => rtrim($prefix, '/'),
            ]);

            Permission::firstOrCreate(['name' => $row->permissionName(), 'guard_name' => 'web']);
        }

        $this->createMenu($model);
    }

    protected function createMenu($model)
    {
        $menu_name  = preg_replace('/([^A-Z-])([A-Z])/', '$1 $2', $model);
        $menu_name  = ucfirst($menu_name);

        $parent = Menu::firstOrCreate([
            'name->en' => $model,
            'route'    => '#',
            'parent_id'=> null
        ], [
            'name' => ['en' => $model, 'ar' => $model],
            'route' => '#',
            'icon' => "fa fa-gears",
            'parent_id' => null
        ]);

        Menu::firstOrCreate([
            'name->en' => $model,
            'route'    => "$model.index",
            'parent_id'=> $parent->id
        ], [
            'name' => ['en' => "List $model", 'ar' => "List $model"],
            'route' => "$model.index",
            'icon' => "fa fa-list",
            'parent_id' => $parent->id
        ]);

        Menu::firstOrCreate([
            'name->en' => $model,
            'route'    => "$model.create",
            'parent_id'=> $parent->id
        ], [
            'name' => ['en' => "Create $model", 'ar' => "Create $model"],
            'route' => "$model.create",
            'icon' => "fa fa-plus",
            'parent_id' => $parent->id
        ]);
    }
}
