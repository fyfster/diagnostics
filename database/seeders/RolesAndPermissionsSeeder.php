<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $this->addAdminUser();
        $this->addRolesAndPermissions();
    }

    private function addRolesAndPermissions()
    {
        $roles = [
            'admin',
            'fleet',
            'family',
        ];

        $userPermissions = [
            'user-crud',
            'user-create',
            'user-delete',
            'user-edit',
            'user-read',
        ];

        $carPermissions = [
            'car-crud',
            'car-create',
            'car-delete',
            'car-edit',
            'car-read',
        ];

        $truckPermissions = [
            'truck-crud',
            'truck-create',
            'truck-delete',
            'truck-edit',
            'truck-read',
        ];

        $roleModels = [];
        foreach ($roles as $roleName) {
            $roleModels[$roleName] = Role::firstOrCreate(['name' => $roleName]);
        }

        $allPermissions = array_merge($userPermissions, $carPermissions, $truckPermissions);
        $permissionModels = [];
        foreach ($allPermissions as $permissionName) {
            $permissionModels[$permissionName] = Permission::firstOrCreate(['name' => $permissionName]);
        }

        $fleetRole = $roleModels['fleet'];
        $fleetRole->permissions()->syncWithoutDetaching(
            collect($userPermissions)->map(fn ($name) => $permissionModels[$name]->id)
        );

        foreach (['fleet', 'family'] as $roleName) {
            $role = $roleModels[$roleName];
            $role->permissions()->syncWithoutDetaching(
                collect($carPermissions)->map(fn ($name) => $permissionModels[$name]->id)
            );
        }

        $role = $roleModels['fleet'];
        $role->permissions()->syncWithoutDetaching(
            collect($truckPermissions)->map(fn ($name) => $permissionModels[$name]->id)
        );
    }

    private function addAdminUser()
    {
        $username = config('ADMIN_USERNAME');
        $email = config('ADMIN_EMAIL');
        $password = config('ADMIN_PASSWORD');

        $user = User::firstOrCreate(
            [
                'username' => $username,
                'email' => $email,
                'first_name' => 'admin',
                'name' => 'admin',
                'password' => Hash::make($password),
            ]
        );

        $user->roles()->syncWithoutDetaching(1);
    }
}
