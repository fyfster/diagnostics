<?php

namespace App\Classes\Datatables;

use App\Dto\CarDto;
use App\Dto\DataTables\DataTableDefaultFiltersDto;
use App\Dto\DataTables\DataTableQueryResultDto;
use App\Dto\DataTables\DataTableReturnDto;
use App\Helpers\HtmlHelper;

class UserDatatablesFormat implements DatatablesFormatInterface
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

    static public function createItems(array $users): array
    {
        $formattedUsers = [];

        foreach ($users as $user) {
            $user['actions'] = '';
            if ($user['car_count']) {
                $user['actions'] = HtmlHelper::smallCircleAnchor(
                    route('car-list', ['user_id' => $user['id']]),
                    ['btn-info'],
                    '<i class="fas fa-car"></i>'
                );
            }

            $user['actions'] .= HtmlHelper::smallCircleAnchor(
                route('user-form', ['user_id' => $user['id']]),
                ['btn-warning'],
                '<i class="fas fa-pencil-alt"></i>'
            );

            $user['actions'] .= HtmlHelper::smallCircleButton(
                ['href' => route('user-delete', ['userId' => $user['id']])],
                ['btn-danger', 'user-delete-btn'],
                '<i class="fas fa-trash" data-toggle="modal" data-target="#userDelete"></i>'
            );

            $formattedUsers[] = $user;
        }

        return $formattedUsers;
    }
}
