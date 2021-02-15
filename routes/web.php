<?php

use Emincan\Tracker\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::prefix("/tracker")->get('{any?}', [TrackerController::class, 'index'])
  ->where('any', '.*')->name('tracker');
