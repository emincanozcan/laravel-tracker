<?php

use Emincan\Tracker\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

$middlewares = config('tracker.dashboard.middlewares');
$prefix = config('tracker.dashboard.prefix');

Route::middleware($middlewares)->group(function () use ($prefix) {
    Route::prefix('api/' . $prefix)->group(function () {
        Route::get('last-activities', [TrackerController::class, 'lastActivities'])
      ->name('tracker.last-activities');

        Route::get('activity-statistics', [TrackerController::class, 'activityStatistics'])
      ->name('tracker.activity-statistics');

        Route::get('filters', [TrackerController::class, 'filters'])
      ->name('tracker.filters');

        Route::get('activity-details-by-ip/{ipAddress}', [TrackerController::class, 'activityDetailsByIpAddress'])
      ->name('tracker.activity-details-by-ip');

        Route::get('activity-details-by-trackable/{trackableType}/{trackableId}', [TrackerController::class, 'activityDetailsByTrackable'])
      ->name('tracker.activity-details-by-trackable');
    });

    Route::prefix($prefix)->get('{any?}', [TrackerController::class, 'index'])
    ->where('any', '.*')->name('tracker');
});
