<?php

namespace Tests\Unit;

use App\Http\Controllers\CarController;
use App\Models\Car;
use App\Models\User;
use App\Models\UserCar;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->make(['id' => 1]);
    }

    public function testCarFormViewIsAccessible()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('car-form'));
        $response->assertStatus(200);
        $response->assertViewIs('car.car_form');
    }

    public function testCarListViewIsAccessible()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('car-list'));
        $response->assertStatus(200);
        $response->assertViewIs('car.car_list');
    }

    public function testCreateCarSuccessfully()
    {
        $request = Request::create('/car-create/', 'POST', [
            'name' => 'My Car',
            'brand' => 'Brand',
            'model' => 'Model',
            'production_year' => 2022,
            'registration_number' => 'XYZ123',
            'vin' => '5YJSA1E26JF123456',
        ]);

        $carMock = Mockery::mock('overload:App\Models\Car');
        $carMock->shouldReceive('create')->andReturn((object)['id' => 1]);

        $userCarMock = Mockery::mock('overload:App\Models\UserCar');
        $userCarMock->shouldReceive('create')->once();

        $controller = Mockery::mock(CarController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods()
                   ->shouldReceive('validateCarData')
                   ->once();

        $response = $controller->create($request, $this->user->id);

        $this->assertEquals(302, $response->status());
        $this->assertEquals(session('messageType'), 'success');
    }

    public function testEditCarSuccessfully()
    {
        $request = Request::create('/car-edit', 'POST', [
            'name' => 'My Car',
            'brand' => 'Edit',
            'model' => 'Edit',
            'production_year' => 2024,
            'registration_number' => 'edit',
            'vin' => 'edit',
        ]);

        $carMock = Mockery::mock('overload:App\Models\Car');
        $carMock->shouldReceive('update')->andReturn((object)['id' => 1]);

        $controller = Mockery::mock(CarController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods()
                   ->shouldReceive('validateCarData')
                   ->once();
        $controller->shouldAllowMockingProtectedMethods()
                   ->shouldReceive('checkCar')
                   ->andReturn($carMock);

        $response = $controller->edit($request);

        $this->assertEquals(302, $response->status());
        $this->assertEquals(session('messageType'), 'success');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
