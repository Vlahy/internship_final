<?php

namespace Database\Seeders;

use App\Models\AssignmentGroup;
use Illuminate\Database\Seeder;

class AssignmentGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssignmentGroup::factory(5)->create();
    }
}
