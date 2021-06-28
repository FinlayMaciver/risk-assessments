<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\Substance;
use App\Models\SubstanceHazard;
use App\Models\SubstanceRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubstanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Substance::class;

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
            'substance' => $this->faker->word(),
            'quantity' => $this->faker->randomElement([
                'Small < 10mg',
                'Moderate 10mg - 10g',
                'Large 10g - 100g',
                'Very large > 100g',
            ]),
            'single_acute_effect' => $this->faker->randomElement([
                'Serious',
                'Not serious',
                'Not known',
            ]),
            'repeated_low_effect' => $this->faker->randomElement([
                'Serious',
                'Not serious',
                'Not known',
            ]),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Substance $substance) {
            SubstanceHazard::factory()->count(rand(0, 4))->create([
                'substance_id' => $substance->id,
            ]);
            SubstanceRoute::factory()->count(rand(0, 4))->create([
                'substance_id' => $substance->id,
                'substance_type' => 'substance'
            ]);
        });
    }
}
