<?php

use Emincan\Tracker\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::get('api/tracker/get-last-activities', [TrackerController::class, 'lastActivities'])->name('tracker.last-activities');
Route::get('api/tracker/get-activity-statistics', [TrackerController::class, 'activityStatistics'])->name('tracker.activity-statistics');
Route::get('api/tracker/get-filters', [TrackerController::class, 'filters'])->name('tracker.filters');
