<?php

namespace App\Helpers;

use App\Dto\Notifications\InfoNotification;
use App\Dto\Notifications\NotificationInterface;
use App\Dto\Notifications\RpmNotification;
use App\Dto\Notifications\SpeedNotification;
use App\Models\Notification;

class NotificationHelper
{
    PRIVATE CONST MAX_SPEED = 110;
    PRIVATE CONST MAX_RPM = 3500;

    static private function checkIfDiagnosticNotifiable(array $diagnostic): array
    {
        $notifications = [];

        if ($diagnostic['speed'] > self::MAX_SPEED) {
            $notificationMessage = sprintf(
                "Autovehicolul %s a ajuns la viteza %s", 
                $diagnostic["carName"], 
                $diagnostic['speed']
            );
            $notifications[] = new SpeedNotification($notificationMessage);
        }

        if ($diagnostic['rpm'] > self::MAX_RPM) {
            $notificationMessage = sprintf(
                "Autovehicolul %s a ajuns la turatiile %s", 
                $diagnostic["carName"], 
                $diagnostic['rpm']
            );
            $notifications[] = new RpmNotification($notificationMessage);
        }

        return $notifications;
    }

    static public function notify(array $diagnostic, int $userId)
    {
        $notifiable = self::checkIfDiagnosticNotifiable($diagnostic);
        if (!$notifiable){
            return;
        }

        foreach ($notifiable as $notification) {
            Notification::create([
                'user_id' =>  $userId,
                'type' => $notification->getType(),
                'data' => $notification->getData(),
                'created_at' => now(),
            ]);
        }
    }

    static public function getNotificationByType(string $notificationType): NotificationInterface
    {
        return match ($notificationType) {
            'speed' => new SpeedNotification(),
            'rpm' => new RpmNotification(),
            'info' => new InfoNotification(),
        };
    }
}