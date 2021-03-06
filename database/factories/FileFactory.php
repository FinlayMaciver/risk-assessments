<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
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
            'filename' => $this->faker->unique()->word().'.pdf',
            'original_filename' => $this->faker->unique()->word().'.pdf',
            'mimetype' => 'application/pdf',
            'size' => $this->faker->randomNumber(5),
        ];
    }
}
