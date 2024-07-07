<?php

namespace App\Notifications;

use App\Dto\Notifications\NotificationInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class DatabaseNotification extends Notification implements ShouldQueue
{
    use Queueable;


    protected NotificationInterface $details;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(NotificationInterface $details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => $this->details->getData(),
            'type' => $this->details->getType()
        ];
    }
}