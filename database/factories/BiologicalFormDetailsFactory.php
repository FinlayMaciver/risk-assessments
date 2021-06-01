<?php

namespace Database\Factories;

use App\Models\BiologicalFormDetails;
use App\Models\FormMicroOrganism;
use App\Models\FormRisk;
use App\Models\FormSubstance;
use Illuminate\Database\Eloquent\Factories\Factory;

class BiologicalFormDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BiologicalFormDetails::class;

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
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (BiologicalFormDetails $details) {
            FormRisk::factory()->count(rand(0, 4))->create([
                'form_id' => $details->form_id,
            ]);
            FormSubstance::factory()->count(rand(0, 4))->create([
                'form_id' => $details->form_id,
            ]);
            FormMicroOrganism::factory()->count(rand(0, 4))->create([
                'form_id' => $details->form_id,
            ]);
        });
    }
}
