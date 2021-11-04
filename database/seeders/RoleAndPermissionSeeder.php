<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate all roles and permissions before seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $arrayOfPermissions = [
            'create intern',
            'read intern',
            'edit intern',
            'delete intern'
        ];
        // TODO add permissions for all controllers

        $permissions = collect($arrayOfPermissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $recruiter = Role::create(['name' => 'recruiter']);
        $mentor = Role::create(['name' => 'mentor']);

        // Assign permissions to roles
        $admin->givePermissionTo('edit intern');
    }
}
