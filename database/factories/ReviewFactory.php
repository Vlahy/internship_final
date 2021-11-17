<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Intern;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pros' => $this->faker->sentence(8, true),
            'cons' => $this->faker->sentence(6, true),
            'mark' => 'good',
            'assignment_id' => Assignment::all()->random()->id,
            'mentor_id' => User::all()->random()->id,
            'intern_id' => Intern::all()->random()->id,
        ];
    }
}
