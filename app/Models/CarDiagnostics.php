<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class CarDiagnostics extends MyModel
{
    CONST PAUSE_TIME = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'car_id',
        'speed',
        'rpm',
        'fuel_percentage',
        'coolant_temperature',
        'race_number',
        'engine_load',
        'fuel_rate',
        'dtc',
        'total_km',
        
    ];

    public function getLastRaceIdBeforePause(int $carId): ?CarDiagnostics
    {
        $result = $this->from('car_diagnostics as stats1')
            ->select('stats1.id')
            ->join('car_diagnostics as stats2', function ($join) {
                $join->on('stats1.car_id', '=', 'stats2.car_id')
                     ->whereRaw('stats1.created_at < stats2.created_at');
            })
            ->whereRaw("stats2.created_at > stats1.created_at + interval '".self::PAUSE_TIME." minutes'")
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('car_diagnostics as stats3')
                      ->whereRaw('stats3.car_id = stats1.car_id')
                      ->whereRaw('stats3.created_at > stats1.created_at')
                      ->whereRaw('stats3.created_at < stats2.created_at');
            })
            ->where('stats1.car_id', $carId)
            ->orderBy('stats1.created_at')
            ->limit(1)
            ->first();

        return $result;
    }

    public function getRacesFoCar(int $carId, int $limit): ?Collection
    {
        $result = $this->from('car_diagnostics as stats')
            ->selectRaw('stats.id,
                stats.race_number, 
                stats.car_id,
                MAX(stats.created_at) as max_created_at,
                MIN(stats.created_at) as min_created_at
            ')
            ->where('stats.car_id', $carId)
            ->groupBy('stats.race_number')
            ->orderBy('stats.race_number', 'desc')
            ->limit($limit)
            ->get();

        return $result;
    }
}
