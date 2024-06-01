<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CarDiagnostics extends Model
{
    CONST PAUSE_TIME = 10;

    use HasFactory;

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
        'race_number'
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
}
