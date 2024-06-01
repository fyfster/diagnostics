<?php

namespace App\Http\Controllers\API;

use App\Dto\CarDto;
use App\Helpers\HtmlHelper;
use App\Models\Car;
use App\Models\CarDiagnostics;
use Illuminate\Http\Request;

class CarDiagnosticsController extends MyApiController
{
    public function addDiagnostics(Request $request)
    {
        $input = $request->all();

        /** @var CarDto $carDto */
        $carDto = CarDto::create(Car::where('vin', $input['vin'])->first()->toArray());

        if (!$carDto) {
            return response()->json(['error' => 'Car not found'], HtmlHelper::NOT_FOUND);
        }

        try {
            $this->validateCarDiagnostics($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Car diagnostics are not valid - ' . $e->getMessage()], HtmlHelper::OK);
        }

        $lastCarDiagnostics = CarDiagnostics::where('car_id', $carDto->id)->orderBy('id', 'desc')->first();
        $raceNumber = 1;
        if ($lastCarDiagnostics) {
            $raceNumber = $lastCarDiagnostics->created_at->diffInMinutes(now()) <= CarDiagnostics::PAUSE_TIME
            ? $lastCarDiagnostics->race_number
            : $lastCarDiagnostics->race_number + 1;
        }

        CarDiagnostics::create([
            'car_id' => $carDto->id,
            'rpm' => $input['rpm'] ?? null,
            'speed' => $input['speed'] ?? null,
            'fuel_percentage' => $input['fuel_percentage'] ?? null,
            'coolant_temperature' => $input['coolant_temperature'] ?? null,
            'race_number' => $raceNumber,
        ]);

        return response()->json(['success' => 'Car diagnostics saved'], HtmlHelper::OK);
    }

    private function validateCarDiagnostics(Request $request)
    {
        $request->validate([
            'rpm' => 'integer',
            'speed' => 'integer',
            'fuel_percentage' => 'integer|min:0|max:100',
            'coolant_temperature' => 'integer|min:-40|max:215'
        ]);
    }
}
