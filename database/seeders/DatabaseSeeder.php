<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            GroupSeeder::class,
            UserSeeder::class,
            AssignmentSeeder::class,
            AssignmentGroupSeeder::class,
            InternSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
