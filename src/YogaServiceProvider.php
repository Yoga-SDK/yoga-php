<?php

namespace Yoga;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Yoga\Auth\Providers\IdentityAndPasswordProvider;

class YogaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/yoga.php' => config_path('yoga.php'),
        ], 'config');
        $this->mergeConfigFrom(__DIR__.'/../config/yoga.php', 'yoga');
        $this->loadMigrationsFrom(__DIR__.'/../database');

        if (config('yoga.auth.enabled')) {
            Yoga::registerAuthRoutes();
        }
    }
}
