<?php

namespace App\Dto\DataTables;

use App\Dto\AbstractDto;

class DataTableReturnDto extends AbstractDto
{
    public int $draw;
    public int $recordsTotal;
    public int $recordsFiltered;
    public array $data;
}