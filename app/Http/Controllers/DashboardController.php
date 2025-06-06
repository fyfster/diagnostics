<?php

namespace App\Http\Controllers;

use App\Models\CarDiagnostics;

class DashboardController extends MyController
{
    public function index()
    {
        $this->data['lastRaceChart'] = $this->getRaceChart();

        return view('dashboard', $this->data);
    }

    private function getRaceChart()
    {
        $lastCarDiagnostics = CarDiagnostics::where('car_id', 1)->orderBy('id', 'desc')->first();
        $raceNumber = $lastCarDiagnostics->race_number;

        $diagnostics = CarDiagnostics::where('car_id', 1)
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
            ->size(["width" => 400, "height" => 170])
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
}
