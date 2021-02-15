<?php

use Emincan\Tracker\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/tracker/get-last-activities', [TrackerController::class, 'lastActivities'])->name('tracker.last-activities');
Route::get('/tracker/get-activity-statistics', [TrackerController::class, 'activityStatistics'])->name('tracker.activity-statistics');
