<?php

namespace App\Classes\Datatables;

use App\Dto\CarDto;
use App\Dto\DataTables\DataTableDefaultFiltersDto;
use App\Dto\DataTables\DataTableQueryResultDto;
use App\Dto\DataTables\DataTableReturnDto;
use App\Helpers\HtmlHelper;

class CarDatatablesFormat implements DatatablesFormatInterface
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

    static public function createItems(array $cars): array
    {
        $formattedCars = [];

        foreach ($cars as $car) {
            $car['actions'] = HtmlHelper::smallCircleButton(
                ['href' => route('car-diagnostics'), 'id' => $car['id']],
                ['btn-info'],
                '<i class="fas fa-info-circle show-car-stats"></i>'
            );

            $car['actions'] .= HtmlHelper::smallCircleAnchor(
                route('car-form', ['carId' => $car['id']]),
                ['btn-warning'],
                '<i class="fas fa-pencil-alt"></i>'
            );

            $car['actions'] .= HtmlHelper::smallCircleButton(
                ['href' => route('car-delete', ['carId' => $car['id']])],
                ['btn-danger', 'car-delete-btn'],
                '<i class="fas fa-trash" data-toggle="modal" data-target="#carDelete"></i>'
            );

            $formattedCars[] = $car;
        }

        return $formattedCars;
    }
}
