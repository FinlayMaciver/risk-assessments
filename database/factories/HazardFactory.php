<?php

namespace Database\Factories;

use App\Models\Hazard;
use Illuminate\Database\Eloquent\Factories\Factory;

class HazardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
        ];
    }
}
