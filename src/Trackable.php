<?php

namespace Emincan\Tracker;

use Emincan\Tracker\Models\TrackerActivity;

trait Trackable
{
    public function saveActivity($action, $message = null)
    {
        $requestTracker = app()->make(RequestTracker::class);
        TrackerActivity::create([
            "request_id" => $requestTracker->getRequestId(),
            "trackable_id" => $this->id,
            "trackable_type" => get_class($this),
            "ip_address" => $requestTracker->getIpAddress(),
            "action" => $action,
            "message" => $message
        ]);
    }

    public function getActivities()
    {
        return TrackerActivity::where([
            "trackable_type" => get_class($this),
            "trackable_id" => $this->id
        ])->get();
    }
}
