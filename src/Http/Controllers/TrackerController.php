<?php


namespace Emincan\Tracker\Http\Controllers;


class TrackerController
{
    public function index()
    {
        return view('tracker::dashboard');
    }
}
