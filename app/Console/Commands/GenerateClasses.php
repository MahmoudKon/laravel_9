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

        if (file_exists("app/Models/{$model}.php")) {
            $this->error("model class {$model} already exists!");
        } else {
            Artisan::call("make:model $model");
            $this->info("model class<options=bold> {$model}.php </>created successfully!");
        }

        if (file_exists("app/Http/Controllers/Backend/{$model}Controller.php")) {
            $this->error("controller class {$model}Controller already exists!");
        } else {
            Artisan::call("make:controller Backend/{$model}Controller --model=$model --type=custom");
            $this->info("controller class<options=bold> {$model}Controller.php </>created successfully!");
        }

        if (file_exists("app/Http/Services/{$model}Service.php")) {
            $this->error("service class {$model}Service already exists!");
        } else {
            Artisan::call("make:service {$model}Service");
            $this->info("service class<options=bold> {$model}Service.php </>created successfully!");
        }

        Artisan::call("make:migration ".$this->getMigrationName($model));
        $this->info("migration class<options=bold> ".$this->getMigrationName($model).".php </>created successfully!");

        if (file_exists("app/DataTables/{$model}DataTable.php")) {
            $this->error("datatable class {$model}Datatable already exists!");
        } else {
            Artisan::call("datatables:make $model");
            $this->info("datatable class<options=bold> {$model}Datatable.php </>created successfully!");
        }

        if (file_exists("app/Observers/{$model}Observer.php")) {
            $this->error("observe class {$model}Observer already exists!");
        } else {
            Artisan::call("make:observer {$model}Observer --model=$model");
            $this->info("observe class<options=bold> {$model}Observer.php </>created successfully!");
        }

        if (file_exists("app/Http/Requests/{$model}Request.php")) {
            $this->error("request class {$model}Request already exists!");
        } else {
            Artisan::call("make:request ".$model."Request");
            $this->info("request class<options=bold> {$model}Request.php </>created successfully!");
        }

        $view_path = "backend/{$this->getPluralName($model)}/form";
        if (file_exists(resource_path("views/$view_path.blade.php"))) {
            $this->error("view blade {$view_path} already exists!");
        } else {
            Artisan::call("make:view $view_path");
            $this->info("View blade<options=bold> {$view_path}.blade.php </>created successfully!");
        }



        $this->createRoutes($model);

        $this->info("<options=bold>All classes genrated successfully!</>");
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
        $namespace    = "app/Http/Controllers\Backend";
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

        $this->info('<options=bold>Routes </>inserted in database successfully!');
        $this->warn('*******************************************************************************************');
        $this->warn('*******************************************************************************************');
        $this->warn('*** please check your route file, to add a routes about this class like laravel syntax! ***');
        $this->warn('*******************************************************************************************');
        $this->warn('*******************************************************************************************');

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
        $this->info('<options=bold>Menu </>inserted in database successfully!');
    }
}
