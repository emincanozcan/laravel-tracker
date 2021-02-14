<?php

namespace Emincan\Tracker;

use Emincan\Tracker\Models\TrackerActivity;

trait Trackable
{
    public function saveActivity($action, $message = null)
    {
        $requestTracker = app()->make(RequestTracker::class);
        TrackerActivity::create([
            "user_id" => $this->id,
            "request_id" => $requestTracker->getRequestId(),
            "ip_address" => $requestTracker->getIpAddress(),
            "action" => $action,
            "message" => $message
        ]);
    }

    public function getActivities()
    {
        return TrackerActivity::whereUserId($this->id)->get();
    }
}
