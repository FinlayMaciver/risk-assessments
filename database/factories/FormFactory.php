<?php

namespace Database\Factories;

use App\Models\BiologicalFormDetails;
use App\Models\ChemicalFormDetails;
use App\Models\Form;
use App\Models\GeneralFormDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Form::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker()->word(),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'multi_user' => false,
            'status' => 'Pending',

            'title' => $this->faker->sentence(rand(1, 4)),
            'location' => $this->faker->city(),
            'description' => $this->faker->sentence(rand(10, 20)),
            'control_measures' => $this->faker->sentence(rand(5, 10)),
            'work_site' => $this->faker->randomElement([
                'Open bench',
                'Fume Cupboard',
                'Glove box',
                'Other'
            ]),
            'further_risks' => $this->faker->randomElement([
                null,
                'None',
                $this->faker->sentence(rand(7, 14))
            ]),
            'disposal_methods' => $this->faker->randomElement([
                'None',
                $this->faker->sentence(rand(7, 14))
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

            //Supervisor/Guardian
            'supervisor_id' => function () {
                return User::factory()->staff()->create()->id;
            },
            'lab_guardian_id' => function () {
                return User::factory()->staff()->create()->id;
            },
        ];
    }

    public function general()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'General',
            ];
        })->afterCreating(function (Form $form) {
            GeneralFormDetails::factory()->create([
                'form_id' => $form->id,
            ]);
        });
    }

    public function chemical()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'Chemical'
            ];
        })->afterCreating(function (Form $form) {
            ChemicalFormDetails::factory()->create([
                'form_id' => $form->id,
            ]);
        });
    }

    public function biological()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'Biological'
            ];
        })->afterCreating(function (Form $form) {
            BiologicalFormDetails::factory()->create([
                'form_id' => $form->id,
            ]);
        });
    }

    public function multiuser()
    {
        return $this->state(function (array $attributes) {
            return [
                'multi_user' => true,
            ];
        });
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Approved',
            ];
        });
    }

    public function denied()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Denied',
            ];
        });
    }
}
