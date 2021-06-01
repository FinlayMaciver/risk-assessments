<?php

namespace Database\Factories;

use App\Models\FormSubstance;
use App\Models\FormSubstanceHazard;
use App\Models\Hazard;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormSubstanceHazardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormSubstanceHazard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_substance_id' => function () {
                return FormSubstance::factory()->create()->id;
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
                        'Teratogen'
                    ])
                ])->id;
            }
        ];
    }
}
