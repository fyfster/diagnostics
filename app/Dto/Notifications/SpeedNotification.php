<?php

namespace App\Dto\Notifications;

class SpeedNotification implements NotificationInterface
{
    protected $data;
    protected $type = 'speed';
    protected $icon = 'fa-car-crash';

    public function __construct(string $data = null)
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

    public function setData(string $data)
    {
        $this->data = $data;
    }

    public function getFaIcon()
    {
        return $this->icon;
    }
}