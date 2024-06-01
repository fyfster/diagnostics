<?php

namespace App\Http\Controllers;

use App\Classes\Datatables\UserDatatablesFormat;
use App\Dto\DataTables\DataTableUserFiltersDto;
use App\Helpers\DataTablesHelper;
use Illuminate\Http\Request;
use App\Models\User as UserModel;
use App\Models\UserCar;

class UserController extends MyController
{
    public function form($userId = null)
    {
        if ($userId) {
            $this->data['userId'] = $userId;
            $this->data['user'] = UserModel::find($userId);
        }
        $this->data['routeUrl'] = $userId ? 'user-edit' : 'user-create';

        return view('user/user_form', $this->data);
    }

    public function list()
    {
        return view('user/user_list', $this->data);
    }

    public function listDataTables(Request $request)
    {
        $dataTablesFilters = DataTablesHelper::generateDefaultFilter($request, new DataTableUserFiltersDto);

        $users = (new UserModel())->dataTablesGetUsers($dataTablesFilters);

        return response()->json(UserDatatablesFormat::format($users, $dataTablesFilters));
    }

    public function edit(Request $request)
    {
        $input = $request->only([
            'user_id',
            'username',
            'name',
            'first_name',
            'email'
        ]);

        $user = $this->checkUser($input);

        try {
            $this->validateUserData($request, true);
        } catch (\Exception $e) {
            return back()
                ->with($input)
                ->withErrors($e->getMessage());
        }

        try {
            $user->update([
                'username' => $input['username'],
                'first_name' => $input['first_name'],
                'name' => $input['name'],
                'email' => $input['email'],
            ]);
        } catch (\Exception $e) {
            return back()
                ->with($input)
                ->withErrors($e->getMessage());
        }

        return redirect()
            ->route('user-list')
            ->with([
                'messageType' => 'success',
                'messageText' => 'Utilizator modificat cu success!',
            ]);
    }

    public function create(Request $request)
    {
        $input = $request->only([
            'username',
            'name',
            'first_name',
            'email',
            'password',
            'confirm_password',
        ]);

        try {
            $this->validateUserData($request);
        } catch (\Exception $e) {
            return back()
                ->with($input)
                ->withErrors($e->getMessage());
        }

        try {
            UserModel::create([
                'username' => $input['username'],
                'first_name' => $input['first_name'],
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
            ]);
        } catch (\Exception $e) {
            return back()
                ->with($input)
                ->withErrors($e->getMessage());
        }

        return redirect()
            ->route('user-list')
            ->with([
                'messageType' => 'success',
                'messageText' => 'Utilizator creat cu success!',
            ]);
    }

    public function delete($userId)
    {
        $user = $this->checkUser(['user_id' => $userId]);

        try {
            UserCar::where('user_id', $userId)->delete();
            $user->delete();
        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }

        return redirect()
            ->route('user-list')
            ->with([
                'messageType' => 'success',
                'messageText' => 'Utilizatorul modificata cu success!',
            ]);
    }

    private function validateUserData(Request $request, bool $isEdit = false)
    {
        $dataToValidate = [
            'username' => 'required|string',
            'name' => 'required|string',
            'first_name' => 'required|string',
            'email' => 'required|string',
        ];

        if (!$isEdit) {
            $dataToValidate['password'] = 'required|string|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/';
            $dataToValidate['confirm_password'] = 'required|string|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/';
        }

        $request->validate($dataToValidate);

        if ($request->password !== $request->confirm_password) {
            throw new \Exception('Parolele nu conincid!');
        }
    }

    private function checkUser(array $input)
    {
        $userId = $input['user_id'];
        
        $user = UserModel::find($userId);

        if ($user === null) {
            return back()
                ->with($input)
                ->withErrors('Nu s-a gasit utilizatorul cu id-ul specificat!');
        }

        return $user;
    }
}
