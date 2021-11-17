<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

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

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $recruiter = Role::create(['name' => 'recruiter']);
        $mentor = Role::create(['name' => 'mentor']);

    }
}
