<?php

namespace App\Dto\Notifications;

class SpeedNotification implements NotificationInterface
{
    protected $data;
    protected $type = 'speed';

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getType()
    {
        return $this->type;
    }
}