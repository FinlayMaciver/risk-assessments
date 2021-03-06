<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\MicroOrganism;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class MicroOrganismFactory extends Factory
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
        return $this->afterCreating(function (MicroOrganism $substance) {
            $routes = Route::inRandomOrder()->get();
            $substance->routes()->attach($routes->first());
            $substance->routes()->attach($routes->last());
        });
    }
}
