<?php

namespace Emincan\Tracker;

use Emincan\Tracker\Console\Commands\TrackerClearCommand;
use Emincan\Tracker\Console\Commands\TrackerInstallCommand;
use Illuminate\Support\ServiceProvider;

class TrackerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        $this->mergeConfigFrom(__DIR__ . '/../config/tracker.php', 'tracker');
        $this->loadRoutesFrom(__DIR__ . '/../routes/tracker-routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tracker');
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/emincan/tracker'),
        ], 'tracker-assets');
        $this->publishes([
            __DIR__ . "/../config" => config_path('tracker.php')
        ], 'tracker-config');
        if ($this->app->runningInConsole()) {
            $this->commands([
                TrackerClearCommand::class,
                TrackerInstallCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->app->singleton(RequestTracker::class, function () {
            return new RequestTracker();
        });
    }
}
