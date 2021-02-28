<?php


namespace Emincan\Tracker;


class RequestTracker
{
    private $requestId;
    private $ipAddress;

    public function __construct()
    {
        $this->requestId = bin2hex(random_bytes(16));
        $this->ipAddress = request()->ip();
    }

    public function getRequestId()
    {
        return $this->requestId;
    }

    public function getIpAddress()
    {
        return $this->ipAddress;
    }
}
