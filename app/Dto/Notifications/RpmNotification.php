<?php

namespace App\Dto\Notifications;

class RpmNotification implements NotificationInterface
{
    protected $data;
    protected $type = 'rpm';

    public function __construct($data)
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