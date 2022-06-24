<?php

namespace Database\Factories;

use App\Models\CoshhFormDetails;
use App\Models\Form;
use App\Models\MicroOrganism;
use App\Models\Risk;
use App\Models\Substance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class FormFactory extends Factory
{
    public function configure()
    {
        return $this->afterCreating(function (Form $form) {
            Risk::factory()->count(rand(1, 4))->create([
                'form_id' => $form->id,
                'likelihood_without' => $this->faker->numberBetween(1, 5),
                'impact_without' => $this->faker->numberBetween(1, 5),
                'likelihood_with' => $this->faker->numberBetween(1, 5),
                'impact_with' => $this->faker->numberBetween(1, 5),
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
            'location' => $this->getRandomRoom(),
            'review_date' => $this->faker->date(),
            'description' => $this->faker->sentence(rand(10, 20)),

            //Supervisor/Guardian
            'supervisor_id' => function () {
                return User::factory()->staff()->create()->id;
            },
        ];
    }

    protected function getRandomRoom()
    {
        return Arr::random(['JWS', 'Rankine']) . ' ' . Arr::random(['Room', 'Lab']) . ' ' . $this->faker->numberBetween(100, 700);
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
            Substance::factory()->count(rand(1, 4))->create([
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
            MicroOrganism::factory()->count(rand(1, 4))->create([
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

    public function archived()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_archived' => true,
            ];
        });
    }
}
