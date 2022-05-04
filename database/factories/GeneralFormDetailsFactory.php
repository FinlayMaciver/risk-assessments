<?php

namespace Database\Factories;

use App\Models\GeneralFormDetails;
use App\Models\Risk;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneralFormDetailsFactory extends Factory
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

            //General form only
            'chemicals_involved' => $this->faker->word(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (GeneralFormDetails $details) {
            Risk::factory()->count(rand(0, 4))->create([
                'form_id' => $details->form_id,
            ]);
        });
    }
}
