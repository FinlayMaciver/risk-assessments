<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\FormRisk;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormRiskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormRisk::class;

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
            'description' => $this->faker->sentence(rand(1, 5)),
            'control_measures' => $this->faker->sentence(rand(1, 5)),
            'severity' => $this->faker->randomElement([
                'Slight',
                'Moderate',
                'Very',
                'Extremely',
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
