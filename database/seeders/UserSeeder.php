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
            'city' => 'Cuprija',
            'skype' => 'live:.cid.G1UtZY7wJoTUbxCm',
            'group_id' => '1',
        ])
            ->each(function ($user) {
            $user->assignRole('admin');
        });;

        // Create 20 more users
        User::factory(20)->create()->each(function ($user) {
            $user->assignRole('mentor');
        });
    }
}
