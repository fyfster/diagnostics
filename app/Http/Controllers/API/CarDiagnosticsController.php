<?php

namespace App\Http\Controllers\API;

use App\Dto\CarDto;
use App\Helpers\HtmlHelper;
use App\Helpers\NotificationHelper;
use App\Models\Car;
use App\Models\CarDiagnostics;
use App\Models\UserCar;
use Illuminate\Http\Request;

class CarDiagnosticsController extends MyApiController
{
    private const FUEL_HISTORY_CALIBRATION = 9;

    public function addDiagnostics(Request $request)
    {
        $input = $request->all();

        $car = Car::where('vin', $input['vin']);
        if (!$car) {
            return response()->json(['error' => 'Car not found'], HtmlHelper::NOT_FOUND);
        }

        /** @var CarDto $carDto */
        $carDto = CarDto::create($car->first()->toArray());

        try {
            $this->validateCarDiagnostics($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Car diagnostics are not valid - ' . $e->getMessage()], HtmlHelper::OK);
        }

        $raceNumber = $this->loadRaceNumber($carDto->id);

        CarDiagnostics::create([
            'car_id' => $carDto->id,
            'rpm' => $input['rpm'] ?? null,
            'speed' => $input['speed'] ?? null,
            'fuel_percentage' => $this->generalizeFuelPercentage($carDto->id, $input['fuel_percentage']),
            'coolant_temperature' => $input['coolant_temperature'] ?? null,
            'engine_load' => $input['engine_load'] ?? null,
            'fuel_rate' => $input['fuel_rate'] ?? null,
            'dtc' => $input['dtc'] ?? null,
            'total_km' => $input['odometer'] ?? null,
            'race_number' => $raceNumber,
        ]);

        $notificationInfo = [
            'carName' => $carDto->name,
            'speed' => $input['speed'] ?? null,
            'rpm' => $input['rpm'] ?? null,
        ];

        NotificationHelper::notify(
            $notificationInfo, 
            UserCar::where('car_id', $carDto->id)->first()->user_id
        );

        return response()->json(['success' => 'Car diagnostics saved'], HtmlHelper::OK);
    }

    private function loadRaceNumber(int $carId): int
    {
        $lastCarDiagnostics = CarDiagnostics::where('car_id', $carId)->orderBy('id', 'desc')->first();

        $raceNumber = 1;
        if ($lastCarDiagnostics) {
            $raceNumber = $lastCarDiagnostics->created_at->diffInMinutes(now()) <= CarDiagnostics::PAUSE_TIME
            ? $lastCarDiagnostics->race_number
            : $lastCarDiagnostics->race_number + 1;
        }

        return $raceNumber;
    }

    private function generalizeFuelPercentage(int $carId, ?int $newFuelPercentage = null): ?int
    {
        if ($newFuelPercentage === null) {
            return $newFuelPercentage;
        }

        $fuelPercentages = CarDiagnostics::where('car_id', $carId)
            ->orderBy('id', 'desc')
            ->take(self::FUEL_HISTORY_CALIBRATION)
            ->pluck('fuel_percentage');

        $averageFuelPercentage = ($fuelPercentages->sum() + $newFuelPercentage) / ($fuelPercentages->count() + 1);

        return $averageFuelPercentage;
    }

    private function validateCarDiagnostics(Request $request)
    {
        $request->validate([
            'rpm' => 'integer',
            'speed' => 'integer',
            'fuel_percentage' => 'integer|min:0|max:100',
            'coolant_temperature' => 'integer|min:-40|max:215',
            'engine_load' => 'integer|min:0|max:100',
            'fuel_rate' => 'integer|min:0|max:3212',
            'dtc' => 'string',
            'egr' => 'integer|min:0|max:100',
            'odometer' => 'integer|min:0',
        ]);
    }
}
