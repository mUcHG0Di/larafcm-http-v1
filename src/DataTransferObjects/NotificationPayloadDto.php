<?php

namespace Muchg0di\LarafcmHttpV1\DataTransferObjects;

class NotificationPayloadDto
{
    protected $title;
    protected $body;
    protected $data;

    public function __construct($title, $body, $data = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    public function getData()
    {
        return $this->data;
    }
}