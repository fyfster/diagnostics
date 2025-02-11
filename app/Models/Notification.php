<?php

namespace App\Models;

use App\Dto\DataTables\DataTableNotificationFiltersDto;
use App\Dto\DataTables\DataTableQueryResultDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends MyModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'car_id',
        'type',
        'data',
        'read_at',
        'created_at',
    ];

    public function dataTablesGetNotifications(DataTableNotificationFiltersDto $filters): DataTableQueryResultDto
    {
        $query = $this->from('notifications as n')
            ->select('n.id', 'n.data', 'n.type', 'n.car_id', 'n.created_at')
            ->where('n.user_id', $filters->userId)
            ->when($filters->search, function ($query, $search) {
                return $query->where('n.data', 'like', "%$search%")
                    ->orWhere('n.type', 'like', "%$search%");
            })
            ->when($filters->carId, function ($query, $carId) {
                return $query->join('cars as c', 'n.car_id', '=', 'c.id')
                    ->where('n.car_id', $carId);
            })
            ->when($filters->orderColumnName, function ($query, $orderColumnName) use ($filters) {
                return $query->orderBy($orderColumnName, $filters->orderColumnDir);
            });

        $count = (clone $query)->count();
        $result = $query
            ->skip($filters->start)
            ->take($filters->length)
            ->get()
            ->toArray();

        return DataTableQueryResultDto::create(['count' => $count, 'result' => $result]);
    }
}
