<?php

namespace App\Dto\DataTables;

class DataTableNotificationFiltersDto extends DataTableDefaultFiltersDto
{
    public int $userId;
    public ?int $carId = null;
}