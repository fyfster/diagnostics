<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make(['id' => 1]);
    }

    public function testUserFormViewIsAccessible()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('user-form'));
        $response->assertStatus(200);
        $response->assertViewIs('user.user_form');
    }

    public function testUserListViewIsAccessible()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('user-list'));
        $response->assertStatus(200);
        $response->assertViewIs('user.user_list');
    }

    public function testCreateUserSuccessfully()
    {
        $request = Request::create('/user-create', 'POST', [
            'username' => 'john_doe',
            'name' => 'Doe',
            'first_name' => 'John',
            'email' => 'john@example.com',
            'password' => 'Test1234',
            'confirm_password' => 'Test1234',
        ]);

        $controller = Mockery::mock(UserController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods()
                    ->shouldReceive('validateUserData')
                    ->once();

        $response = $controller->create($request);

        $this->assertEquals(302, $response->status());
        $this->assertEquals(session('messageType'), 'success');
    }

    public function testEditUserSuccessfully()
    {
        $request = Request::create('/user-edit', 'POST', [
            'user_id' => 1,
            'username' => 'editeduser',
            'name' => 'Edited',
            'first_name' => 'User',
            'email' => 'edited@example.com',
        ]);

        $userMock = Mockery::mock();
        $userMock->shouldReceive('update')->once();

        $controller = Mockery::mock(UserController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods()
                    ->shouldReceive('validateUserData')
                    ->once();
        $controller->shouldAllowMockingProtectedMethods()
                    ->shouldReceive('checkUser')
                    ->andReturn($userMock);

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
