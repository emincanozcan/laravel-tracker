<?php


namespace Emincan\Tracker\Http\Controllers;


use Emincan\Tracker\Models\TrackerActivity;

class TrackerController
{
    public function index()
    {
        return view('tracker::dashboard', [
            "activityData" => TrackerActivity::paginate(2)
        ]);
    }
}
