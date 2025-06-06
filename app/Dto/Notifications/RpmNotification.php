<?php

namespace App\Dto\Notifications;

class RpmNotification implements NotificationInterface
{
    protected $data;
    protected $type = 'rpm';
    protected $icon = 'fa-car-battery';

    public function __construct($data = null)
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