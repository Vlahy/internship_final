<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'assignment_id' => Assignment::all()->random()->id,
            'group_id' => Group::all()->random()->id,
            'start_date' => null,
            'end_date' => null,
            'is_active' => false,
        ];
    }
}
