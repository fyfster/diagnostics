<?php

namespace App\Http\Controllers;

use App\Models\Car as CarModel;
use App\Models\CarDiagnostics;

class RaceController extends MyController
{
    CONST LAST_RACE_NUMBERS = 10;

    public function list($carId = null)
    {
        $this->data['carId'] = $carId;

        $this->checkCar(['car_id' => $carId]);

        $carDiagnostics = new CarDiagnostics();
        $races = $carDiagnostics->getRacesFoCar($carId, self::LAST_RACE_NUMBERS);

        $charts = [];
        foreach ($races as $race) {
            $charts[$race->race_number] = $this->getRaceChart($carId, $race->race_number);
        }
        $this->data['races'] = $races;
        $this->data['charts'] = $charts;
        $this->data['race_nr'] = min(self::LAST_RACE_NUMBERS, count($races));

        return view('race/race_list', $this->data);
    }

    private function getRaceChart(int $carId, int $raceNumber)
    {
        $diagnostics = CarDiagnostics::where('car_id', $carId)
            ->where('race_number', $raceNumber)
            ->orderBy('created_at', 'asc')
            ->get();

        $speeds = $diagnostics->pluck('speed')->toArray();
        $rpm = $diagnostics->pluck('rpm')->toArray();
        $fuel = $diagnostics->pluck('fuel_percentage')->toArray();
        $hours = $diagnostics->map(function ($diagnostic) {
            return $diagnostic->created_at->format('H:i');
        })->toArray();
        
        return app()
            ->chartjs->name("CarSpeedChart$raceNumber")
            ->type("line")
            ->size(["width" => 400, "height" => 150])
            ->labels($hours)
            ->datasets([
                [
                    "label" => "Viteza masinii",
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "data" => $speeds
                ],
                [
                    "label" => "Turatiile masinii",
                    "backgroundColor" => "rgba(255, 0, 0, 0.31)",
                    "borderColor" => "rgba(255, 0, 0, 0.7)",
                    "data" => $rpm,
                    "hidden" => true,
                ],
                [
                    "label" => "Procentaj carburant",
                    "backgroundColor" => "rgba(255, 255, 0, 0.31)",
                    "borderColor" => "rgba(255, 255, 0, 0.7)",
                    "data" => $fuel,
                    "hidden" => true,
                ]
            ])
            ->options([
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => 'month'
                        ],
                        'min' => reset($hours),
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Viteza masinii in timpul cursei'
                    ]
                ]
            ]);
    }

    private function checkCar(array $input)
    {
        $carId = $input['car_id'];

        $car = CarModel::find($carId);

        if ($car === null) {
            return back()
                ->with($input)
                ->withErrors('Nu s-a gasit masina cu id-ul specificat!');
        }

        return $car;
    }
}
