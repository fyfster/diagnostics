<?php

namespace App\Dto\DataTables;

use App\Dto\AbstractDto;

class DataTableQueryResultDto extends AbstractDto
{
    public int $count;
    public array $result;
}