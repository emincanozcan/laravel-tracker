<?php

namespace Emincan\Tracker;

use Illuminate\Support\ServiceProvider;

class TrackerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
    }

    public function register()
    {
        $this->app->singleton(RequestTracker::class, function () {
            return new RequestTracker();
        });
    }
}
