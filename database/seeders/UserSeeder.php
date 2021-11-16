<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default admin user
        User::factory(1)->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ])
            ->each(function ($user) {
            $user->assignRole('admin');
        });

        // Create default recruiter user
        User::factory(1)->create([
            'name' => 'Recruiter',
            'email' => 'recruiter@recruiter.com',
            'password' => bcrypt('12345678'),
        ])
            ->each(function ($user) {
                $user->assignRole('recruiter');
            });


        // Create 20 more users
        User::factory(20)->create()->each(function ($user) {
            $user->assignRole('mentor');
        });
    }
}
