<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Substance;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubstanceRouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubstanceRoute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'substance_id' => function () {
                return Substance::factory()->create()->id;
            },
            'route_id' => function () {
                if (Route::count()) {
                    return Route::find(rand(1, Route::count()))->id;
                }
                return Route::factory()->create([
                    'title' => $this->faker->unique()->randomElement([
                        'Inhalation',
                        'Ingestion',
                        'Skin absorption',
                        'Eye/skin contact',
                        'Injection'
                    ])
                ])->id;
            }
        ];
    }
}
