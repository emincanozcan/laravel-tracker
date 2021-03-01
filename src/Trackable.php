<?php

namespace Emincan\Tracker;

use Emincan\Tracker\Models\TrackerActivity;

trait Trackable
{
    protected static $trackEvents = ["created", "updated", "deleted"];

    public function saveActivity($action, $message = null, $additionalData = [])
    {
        (new Tracker)
            ->setTrackable(get_class($this), $this->id)
            ->setAction($action)
            ->setMessage($message)
            ->setAdditionalData($additionalData)
            ->save();
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
        foreach (self::$trackEvents as $event) {
            $message = class_basename(self::class) . " is " . $event;
            self::$event(function ($model) use ($event, $message) {
                $additionalData = [];
                if ($model->wasChanged()) {
                    $additionalData = [
                        "original" => $model->getOriginal(),
                        "changes" => $model->getChanges()
                    ];
                }

                (new Tracker)
                    ->setTrackable(self::class, $model->id)
                    ->setAction($event)
                    ->setMessage($message)
                    ->setAdditionalData($additionalData)
                    ->save();
            });
        }
    }
}
