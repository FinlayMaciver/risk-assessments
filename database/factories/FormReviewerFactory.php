<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormReviewerFactory extends Factory
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
            'reviewer_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
