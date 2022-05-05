<?php

namespace Database\Factories;

use App\Models\CoshhFormDetails;
use App\Models\Form;
use App\Models\MicroOrganism;
use App\Models\Risk;
use App\Models\Substance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    public function configure()
    {
        return $this->afterCreating(function (Form $form) {
            Risk::factory()->count(rand(1, 4))->create([
                'form_id' => $form->id,
            ]);
        });
    }
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => 'General',
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'multi_user' => false,
            'status' => 'Pending',
            'title' => $this->faker->sentence(rand(1, 4)),
            'management_unit' => 'School of Engineering',
            'location' => $this->faker->city(),
            'review_date' => $this->faker->date(),
            'description' => $this->faker->sentence(rand(10, 20)),

            //Supervisor/Guardian
            'supervisor_id' => function () {
                return User::factory()->staff()->create()->id;
            },
        ];
    }


    public function chemical()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'Chemical',
            ];
        })->afterCreating(function (Form $form) {
            CoshhFormDetails::factory()->create([
                'form_id' => $form->id,
            ]);
            Substance::factory()->count(rand(0, 4))->create([
                'form_id' => $form->id,
            ]);
        });
    }

    public function biological()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'Biological',
            ];
        })->afterCreating(function (Form $form) {
            CoshhFormDetails::factory()->create([
                'form_id' => $form->id,
            ]);
            MicroOrganism::factory()->count(rand(0, 4))->create([
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
                'supervisor_approval' => true,
            ];
        });
    }

    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'Rejected',
                'supervisor_approval' => false,
                'supervisor_comments' => $this->faker->words(3, true),
            ];
        });
    }
}
