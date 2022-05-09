<?php

namespace Database\Factories;

use App\Models\CoshhFormDetails;
use App\Models\Risk;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoshhFormDetailsFactory extends Factory
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

            'control_measures' => $this->faker->sentence(rand(5, 10)),
            'work_site' => $this->faker->randomElement([
                'Open bench',
                'Fume Cupboard',
                'Glove box',
                'Other',
            ]),
            'further_risks' => $this->faker->randomElement([
                null,
                'None',
                $this->faker->sentence(rand(7, 14)),
            ]),
            'disposal_methods' => $this->faker->randomElement([
                'None',
                $this->faker->sentence(rand(7, 14)),
            ]),

            //Equipment
            'eye_protection' => $this->faker->boolean(),
            'face_protection' => $this->faker->boolean(),
            'hand_protection' => $this->faker->boolean(),
            'foot_protection' => $this->faker->boolean(),
            'respiratory_protection' => $this->faker->boolean(),
            'other_protection' => $this->faker->words(3, true),

            //Emergencies
            'instructions' => $this->faker->boolean(),
            'spill_neutralisation' => $this->faker->boolean(),
            'eye_irrigation' => $this->faker->boolean(),
            'body_shower' => $this->faker->boolean(),
            'first_aid' => $this->faker->boolean(),
            'breathing_apparatus' => $this->faker->boolean(),
            'external_services' => $this->faker->boolean(),
            'poison_antidote' => $this->faker->boolean(),
            'other_emergency' => $this->faker->words(3, true),

            //Supervision
            'routine_approval' => $this->faker->boolean(),
            'specific_approval' => $this->faker->boolean(),
            'personal_supervision' => $this->faker->boolean(),

            //Monitoring
            'airborne_monitoring' => $this->faker->boolean(),
            'biological_monitoring' => $this->faker->boolean(),

            //Informing
            'inform_lab_occupants' => $this->faker->boolean(),
            'inform_cleaners' => $this->faker->boolean(),
            'inform_contractors' => $this->faker->boolean(),
            'inform_other' => $this->faker->sentence(rand(1, 3)),
        ];
    }
}
