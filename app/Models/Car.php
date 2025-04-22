<?php

namespace App\Models;

use App\Dto\DataTables\DataTableCarFiltersDto;
use App\Dto\DataTables\DataTableQueryResultDto;
use Illuminate\Support\Facades\DB;

class Car extends MyModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'brand',
        'model',
        'production_year',
        'registration_number',
        'vin',
    ];

    public function getUserCars(int $userId): object
    {
        return $this->from('cars as c')
            ->select('c.id', DB::raw('CONCAT(c.name, " - ", c.model, " ", c.brand) AS name'))
            ->join('user_car as uc', 'uc.car_id', '=', 'c.id')
            ->where('uc.user_id', $userId)
            ->get();
    }

    public function dataTablesGetCars(DataTableCarFiltersDto $filters): DataTableQueryResultDto
    {
        $query = $this->from('cars as c')
            ->select('c.id', 'c.name', 'c.brand', 'c.model', 'c.production_year', 'c.vin', DB::raw('UPPER(c.registration_number) as registration_number'))
            ->join('user_car as uc', 'uc.car_id', '=', 'c.id')
            ->where('uc.user_id', $filters->userId)
            ->when($filters->search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('brand', 'like', "%$search%")
                    ->orWhere('model', 'like', "%$search%")
                    ->orWhere('production_year', 'like', "%$search%")
                    ->orWhere('vin', 'like', "%$search%")
                    ->orWhere('registration_number', 'like', "%$search%");
            })
            ->when($filters->orderColumn, function ($query, $filters) {
                return $query->orderBy($filters->orderColumn, $filters->orderColumnDir);
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
