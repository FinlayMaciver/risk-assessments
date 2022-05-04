<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\Route;
use App\Models\Substance;
use App\Models\SubstanceHazard;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubstanceFactory extends Factory
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
            SubstanceHazard::factory()->count(rand(1, 4))->create([
                'substance_id' => $substance->id,
            ]);
            $routes = Route::inRandomOrder()->get();
            $substance->routes()->attach($routes->first());
            $substance->routes()->attach($routes->last());
        });
    }
}
