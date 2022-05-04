<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'forenames' => $this->faker->firstName(),
            'surname' => str_replace("'", '', $this->faker->lastName()),
            'guid' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'is_staff' => false,
            'is_admin' => false,
            'is_coshh_admin' => false,
            'remember_token' => Str::random(10),
        ];
    }

    public function staff()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_staff' => true,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_staff' => true,
                'is_admin' => true,
            ];
        });
    }

    public function coshhAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_staff' => true,
                'is_admin' => true,
                'is_coshh_admin' => true,
            ];
        });
    }
}
