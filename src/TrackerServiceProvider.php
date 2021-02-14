<?php

namespace Emincan\Tracker;

use Illuminate\Support\ServiceProvider;

class TrackerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tracker');
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/emincan/tracker'),
        ], 'tracker-assets');
    }

    public function register()
    {
        $this->app->singleton(RequestTracker::class, function () {
            return new RequestTracker();
        });
    }
}
