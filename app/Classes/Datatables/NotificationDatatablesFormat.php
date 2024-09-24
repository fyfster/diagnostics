<?php

namespace App\Classes\Datatables;

use App\Dto\DataTables\DataTableDefaultFiltersDto;
use App\Dto\DataTables\DataTableQueryResultDto;
use App\Dto\DataTables\DataTableReturnDto;
use App\Helpers\NotificationHelper;

class NotificationDatatablesFormat implements DatatablesFormatInterface
{
    static public function format(DataTableQueryResultDto $data, DataTableDefaultFiltersDto $filters): DataTableReturnDto
    {
        return DataTableReturnDto::create([
            'draw' => intval($filters->draw),
            'recordsTotal' => intval($data->count),
            'recordsFiltered' => intval($data->count),
            'data' => self::createItems($data->result),
        ]);
    }

    static public function createItems(array $notifications): array
    {
        $formattedNotifications = [];

        foreach ($notifications as $notification) {
            $tempNotificationArray = [];
            $notificationClass = NotificationHelper::getNotificationByType($notification['type']);
            $tempNotificationArray['title'] = '<i class="fas ' . $notificationClass->getFaIcon() . '"></i>'. " " . $notification['data'];
            $tempNotificationArray['created_at'] = $notification['created_at'];

            $formattedNotifications[] = $tempNotificationArray;
        }

        return $formattedNotifications;
    }
}
