<?php

use Emincan\Tracker\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::get('/tracker/get-activities', [TrackerController::class, 'index'])->name('tracker');
