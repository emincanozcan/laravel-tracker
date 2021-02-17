<?php

namespace Emincan\Tracker;

use Emincan\Tracker\Models\TrackerActivity;

class Tracker
{
  private $trackableId;
  private string $trackableType;
  private string $action;
  private string $message;
  private array $additionalData;

  public function setTrackableType($type)
  {
    $this->trackableType = $type;
    return $this;
  }
  public function setTrackableId($id)
  {
    $this->trackableId = $id;
    return $this;
  }
  public function setTrackable($type, $id)
  {
    $this->setTrackableType($type);
    $this->setTrackableId($id);
    return $this;
  }
  public function setAction($action)
  {
    $this->action = $action;
    return $this;
  }
  public function setMessage($message)
  {
    $this->message = $message;
    return $this;
  }
  public function setAdditionalData($additionalData)
  {
    $this->additionalData = $additionalData;
    return $this;
  }
  public function save()
  {
    $requestTracker = app()->make(RequestTracker::class);
    TrackerActivity::create([
      "request_id" => $requestTracker->getRequestId(),
      "ip_address" => $requestTracker->getIpAddress(),
      "trackable_id" => $this->trackableId,
      "trackable_type" => $this->trackableType,
      "action" => $this->action,
      "message" => $this->message,
      "additional_data" => $this->additionalData
    ]);
  }
}
