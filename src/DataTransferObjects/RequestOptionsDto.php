<?php

namespace Muchg0di\LarafcmHttpV1\DataTransferObjects;

class RequestOptionsDto
{
    protected $timeout;
    protected $priority;
    protected $ttl;
    protected $collapseKey;

    public function __construct($timeout = 30, $priority = null, $ttl = null, $collapseKey = null)
    {
        $this->timeout = $timeout;
        $this->priority = $priority;
        $this->ttl = $ttl;
        $this->collapseKey = $collapseKey;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getTtl()
    {
        return $this->ttl;
    }

    public function getCollapseKey()
    {
        return $this->collapseKey;
    }
}