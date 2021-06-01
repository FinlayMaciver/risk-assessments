<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\FormMicroOrganism;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormMicroOrganismFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormMicroOrganism::class;

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
            'micro_organism' => $this->faker->word(),
            'classification' => $this->faker->randomElement([
                'ACDP Class 1',
                'ACDP Class 2',
                'ACDP Class 3',
                'ACDP Class 4',
            ]),
            'risk' => $this->faker->randomElement([
                'Low',
                'Medium',
                'High',
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
}
