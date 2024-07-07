<?php

namespace App\Http\Controllers;

use App\Classes\Datatables\CarDatatablesFormat;
use App\Dto\CarDiagnosticsDto;
use App\Dto\DataTables\DataTableCarFiltersDto;
use App\Helpers\DataTablesHelper;
use App\Models\Car as CarModel;
use App\Models\CarDiagnostics;
use App\Models\UserCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends MyController
{
    public function form($carId = null)
    {
        if ($carId) {
            $this->data['carId'] = $carId;
            $this->data['car'] = CarModel::find($carId);
        }
        $this->data['routeUrl'] = $carId ? 'car-edit' : 'car-create';

        return view('car/car_form', $this->data);
    }

    public function list($userId = null)
    {
        $this->data['userId'] = $userId ?? Auth::user()->id;

        return view('car/car_list', $this->data);
    }

    public function listDataTables(Request $request, $userId = null)
    {
        $dataTablesFilters = DataTablesHelper::generateDefaultFilter($request, new DataTableCarFiltersDto);
        /** @var DataTableCarFiltersDto $dataTablesFilters*/
        $dataTablesFilters->userId = $userId;

        $cars = (new CarModel())->dataTablesGetCars($dataTablesFilters);

        return response()->json(CarDatatablesFormat::format($cars, $dataTablesFilters));
    }

    public function create(Request $request, $userId = null)
    {
        $carInputData = $this->loadCarDataFromInput($request);
        $userId = $userId ?? Auth::user()->id;

        try {
            $this->validateCarData($request);
        } catch (\Exception $e) {
            return back()
                ->with($carInputData)
                ->withErrors($e->getMessage());
        }

        try {
            $carId = CarModel::create($carInputData);
            UserCar::create([
                'user_id' => $userId,
                'car_id' => $carId->id,
            ]);
        } catch (\Exception $e) {
            return back()
                ->with($carInputData)
                ->withErrors($e->getMessage());
        }

        return redirect()
            ->route('car-list')
            ->with([
                'messageType' => 'success',
                'messageText' => 'Masina creata cu success!',
            ]);
    }

    public function edit(Request $request)
    {
        $carInputData = $this->loadCarDataFromInput($request);

        try {
            $this->validateCarData($request);
        } catch (\Exception $e) {
            return back()
                ->with($carInputData)
                ->withErrors($e->getMessage());
        }

        $car = $this->checkCar($carInputData);

        try {
            $car->update($carInputData);
        } catch (\Exception $e) {
            return back()
                ->with($carInputData)
                ->withErrors($e->getMessage());
        }

        return redirect()
            ->route('car-list')
            ->with([
                'messageType' => 'success',
                'messageText' => 'Masina modificata cu success!',
            ]);
    }

    public function delete($carId)
    {
        $car = $this->checkCar(['car_id' => $carId]);

        try {
            CarDiagnostics::where('car_id', $carId)->delete();
            UserCar::where('car_id', $carId)->delete();
            $car->delete();
        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }

        return redirect()
            ->route('car-list')
            ->with([
                'messageType' => 'success',
                'messageText' => 'Masina modificata cu success!',
            ]);
    }

    public function diagnostics(Request $request)
    {
        $carId = $request->get('carId');
        
        $carDiagnsoticsResult = CarDiagnostics::where('car_id', $carId)->orderBy('id', 'desc')->first();
        if ($carDiagnsoticsResult) {
            $carDiagnosticsMax = CarDiagnostics::where('car_id', $carId)
            ->groupBy(['car_id', 'race_number'])
            ->selectRaw('MAX(speed) as max_speed, MAX(rpm) as max_rpm')
            ->where('car_id', $carId)
            ->where('race_number', $carDiagnsoticsResult->race_number)
            ->first();
        }

        return response()->json([
            'carDiagnostics' => CarDiagnosticsDto::create($carDiagnsoticsResult ? $carDiagnsoticsResult->toArray() : []),
            'carDiagnosticsMax' => $carDiagnosticsMax?->toArray(),
        ]);
    }

    private function validateCarData(Request $request)
    {
        $request->validate([
            'name' => 'string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'production_year' => 'required|integer',
            'registration_number' => 'required|string',
            'vin' => 'required|string',
        ]);
    }

    private function loadCarDataFromInput(Request $request)
    {
        return $request->only([
            'car_id',
            'name',
            'brand',
            'model',
            'production_year',
            'registration_number',
            'vin',
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
