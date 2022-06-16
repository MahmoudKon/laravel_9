<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\SettingObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Category::observe(CategoryObserver::class);
        Setting::observe(SettingObserver::class);

        $list_menus = Cache::remember('list_menus', 60 * 60 * 24, function () {
            return Schema::hasTable('menus')
                    ? Menu::with('visibleSubs')->parent()->getVisible()->get()
                    : [];
        });

        View::share('list_menus', $list_menus);
    }
}
