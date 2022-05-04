<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\Risk;
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
            'risk' => $this->faker->sentence(rand(1, 5)),
            'control_measures' => $this->faker->sentence(rand(1, 5)),
            'severity' => $this->faker->randomElement([
                'Slight',
                'Moderate',
                'Very',
                'Extreme',
            ]),
            'likelihood_without' => $this->faker->randomElement([
                'Improbable',
                'Unlikely',
                'Likely',
                'Very likely',
            ]),
            'likelihood_with' => $this->faker->randomElement([
                'Improbable',
                'Unlikely',
                'Likely',
                'Very likely',
            ]),
        ];
    }
}
