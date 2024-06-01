<?php

namespace App\Classes\Datatables;

use App\Dto\DataTables\DataTableDefaultFiltersDto;
use App\Dto\DataTables\DataTableQueryResultDto;

interface DatatablesFormatInterface
{

    static public function format(DataTableQueryResultDto $data, DataTableDefaultFiltersDto $filters);
    static public function createItems(array $data);
}