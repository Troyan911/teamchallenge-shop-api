<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisiionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = config('permission.permissions');

        foreach ($permissions as $resource) {
            foreach ($resource as $permisssion) {
                Permission::findOrCreate($permisssion);
            }
        }

        if (!Role::where('name', Roles::CUSTOMER->value)->exists()) {
            $role = Role::create(['name' => Roles::CUSTOMER->value]);
            $role->givePermissionTo(array_values($permissions['account']));
        }

        if (!Role::where('name', Roles::MODERATOR->value)->exists()) {

            $moderatorPermissions = array_merge(
                array_values($permissions['categories']),
                array_values($permissions['products'])
            );

            $role = Role::create(['name' => Roles::MODERATOR->value]);
            $role->givePermissionTo($moderatorPermissions);
        }

        if (!Role::where('name', Roles::ADMIN->value)->exists()) {
            $role = Role::create(['name' => Roles::ADMIN->value]);
            $role->givePermissionTo(Permission::all());
        }
    }
}
