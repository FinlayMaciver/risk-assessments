<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\Impact;
use App\Models\Likelihood;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_id' => function () {
                return Form::factory()->create()->id;
            },
            'hazard' => $this->faker->sentence(rand(1, 5)),
            'consequences' => $this->faker->sentence(rand(1, 5)),
            'likelihood_without' => function () {
                return Likelihood::factory()->create()->id;
            },
            'impact_without' => function () {
                return Impact::factory()->create()->id;
            },
            'control_measures' => $this->faker->sentence(rand(1, 5)),
            'likelihood_with' => function () {
                return Likelihood::factory()->create()->id;
            },
            'impact_with' => function () {
                return Impact::factory()->create()->id;
            },
            'comments' => $this->faker->sentence(rand(1, 5)),
        ];
    }
}
