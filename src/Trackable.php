<?php

namespace Emincan\Tracker;

use Emincan\Tracker\Models\TrackerActivity;

trait Trackable
{
    public function saveActivity($action, $message = null, $additional_data = [])
    {
        $requestTracker = app()->make(RequestTracker::class);
        TrackerActivity::create([
            "request_id" => $requestTracker->getRequestId(),
            "trackable_id" => $this->id,
            "trackable_type" => get_class($this),
            "ip_address" => $requestTracker->getIpAddress(),
            "action" => $action,
            "message" => $message,
            "additional_data" => $additional_data
        ]);
    }

    public function getActivities()
    {
        return TrackerActivity::where([
            "trackable_type" => get_class($this),
            "trackable_id" => $this->id
        ])->get();
    }

    public static function bootTrackable()
    {
        $events = ["created", "updated", "deleted"];
        foreach ($events as $event) {
            $message = class_basename(self::class) . " is " . $event;
            self::$event(function ($model) use ($event, $message) {

                $additionalData = [];
                if ($event === "updated") $additionalData = ["original" => $model->getOriginal(), "changes" => $model->getChanges()];

                $requestTracker = app()->make(RequestTracker::class);

                TrackerActivity::create([
                    "request_id" => $requestTracker->getRequestId(),
                    "trackable_id" => $model->id,
                    "trackable_type" => self::class,
                    "ip_address" => $requestTracker->getIpAddress(),
                    "action" => $event,
                    "message" => $message,
                    "additional_data" => $additionalData
                ]);
            });
        }
    }
}
