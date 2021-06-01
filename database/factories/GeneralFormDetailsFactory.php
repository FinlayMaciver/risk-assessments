<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\FormRisk;
use App\Models\GeneralFormDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneralFormDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GeneralFormDetails::class;

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
            FormRisk::factory()->count(rand(0, 4))->create([
                'form_id' => $details->form_id,
            ]);
        });
    }
}
