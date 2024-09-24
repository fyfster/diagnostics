<?php

namespace App\Dto\Notifications;

class InfoNotification implements NotificationInterface
{
    protected $data;
    protected $type = 'info';
    protected $icon = 'fa-info-circle';

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