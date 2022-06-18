<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('search comments', function ($user) {
            $count = DB::select("SELECT COUNT(*) AS 'count' FROM task_user_permissions
                        JOIN task_permissions ON task_user_permissions.task_permission_id = task_permissions.id
                        WHERE task_user_permissions.user_id = ".auth()->id()." AND task_permissions.name LIKE '%search comments%'")[0]->count ?? null;
            return $count ? true : false;
        });

        Gate::define('list comments', function ($user) {
            $count = DB::select("SELECT COUNT(*) AS 'count' FROM task_user_permissions
                        JOIN task_permissions ON task_user_permissions.task_permission_id = task_permissions.id
                        WHERE task_user_permissions.user_id = $user->id AND task_permissions.name LIKE '%list comments%'")[0]->count ?? null;
            return $count ? true : false;
        });

        Gate::define('list posts', function ($user) {
            $count = DB::select("SELECT COUNT(*) AS 'count' FROM task_user_permissions
                        JOIN task_permissions ON task_user_permissions.task_permission_id = task_permissions.id
                        WHERE task_user_permissions.user_id = $user->id AND task_permissions.name LIKE '%list posts%'")[0]->count ?? null;
            return $count ? true : false;
        });

        Gate::define('list categories', function ($user) {
            $count = DB::select("SELECT COUNT(*) AS 'count' FROM task_user_permissions
                        JOIN task_permissions ON task_user_permissions.task_permission_id = task_permissions.id
                        WHERE task_user_permissions.user_id = $user->id AND task_permissions.name LIKE '%list categories%'")[0]->count ?? null;
            return $count ? true : false;
        });
    }
}
