<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\FormSubstance;
use App\Models\FormSubstanceHazard;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormSubstanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormSubstance::class;

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
            'route' => $this->faker->randomElement([
                'Inhalation',
                'Ingestion',
                'Skin absorption',
                'Eye/skin contact',
                'Injection'
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
        return $this->afterCreating(function (FormSubstance $substance) {
            FormSubstanceHazard::factory()->count(rand(0, 4))->create([
                'form_substance_id' => $substance->id,
            ]);
        });
    }
}
