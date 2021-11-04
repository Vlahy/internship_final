<?php

namespace Database\Seeders;

use App\Models\Intern;
use Illuminate\Database\Seeder;

class InternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Intern::factory(30)->create();
    }
}
