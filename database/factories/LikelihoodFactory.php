<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LikelihoodFactory extends Factory
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
            'value' => $this->faker->numberBetween(1, 5),
        ];
    }
}
