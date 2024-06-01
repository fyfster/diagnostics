<?php

namespace App\Dto\DataTables;

use App\Dto\AbstractDto;

class DataTableDefaultFiltersDto extends AbstractDto
{
    public string $draw;
    public string $start;
    public string $length;
    public string $search;
    public string $orderColumn;
    public string $orderColumnName;
    public string $orderColumnDir;
    public string $orderMultipleColumns;
}