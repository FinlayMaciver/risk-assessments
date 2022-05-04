<?php

namespace Database\Factories;

use App\Models\Hazard;
use App\Models\Substance;
use App\Models\SubstanceHazard;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubstanceHazardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'substance_id' => function () {
                return Substance::factory()->create()->id;
            },
            'hazard_id' => function () {
                if (Hazard::count()) {
                    return Hazard::find(rand(1, Hazard::count()))->id;
                }

                return Hazard::factory()->create([
                    'title' => $this->faker->unique()->randomElement([
                        'Very toxic',
                        'Toxic',
                        'Harmful',
                        'Corrosive',
                        'Irritant',
                        'Carcinogen',
                        'MEL, OEL',
                        'Dust',
                        'Nanoparticle',
                        'Micro-organism',
                        'Flammable',
                        'Reproductive',
                        'Teratogen',
                    ]),
                ])->id;
            },
        ];
    }
}
