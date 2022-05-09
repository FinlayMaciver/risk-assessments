<?php

namespace Database\Seeders;

use App\Models\Hazard;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Route;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $likelihoods = [
            '1' => 'Very Unlikely',
            '2' => 'Unlikely',
            '3' => 'Fairly likely',
            '4' => 'Likely',
            '5' => 'Very likely',
        ];

        $impacts = [
            '1' => 'Insignificant',
            '2' => 'Minor',
            '3' => 'Moderate',
            '4' => 'Major',
            '5' => 'Catastrophic',
        ];

        $classifications = [
            'Very toxic',
            'Toxic',
            'Harmful',
            'Corrosive',
            'Irritant',
            'Carcinogen',
            'MEL,
            OEL',
            'Dust',
            'Nanoparticle',
            'Micro-organism',
            'Flammable',
            'Reproductive',
            'Teratogen',
        ];

        $routes = [
            'Inhalation',
            'Ingestion',
            'Skin absorption',
            'Eye/skin contact',
            'Injection',
        ];

        foreach ($likelihoods as $key => $likelihood) {
            Likelihood::factory()->create([
                'title' => $likelihood,
                'value' => $key,
            ]);
        }

        foreach ($impacts as $key => $impact) {
            Impact::factory()->create([
                'title' => $impact,
                'value' => $key,
            ]);
        }

        foreach ($classifications as $classification) {
            Hazard::factory()->create(['title' => $classification]);
        }

        foreach ($routes as $route) {
            Route::factory()->create(['title' => $route]);
        }

        User::factory()->admin()->create([
            'forenames' => 'Finlay',
            'surname' => 'Mac',
            'email' => 'finlay.mac@example.com',
            'guid' => 'fmi9x',
        ]);
    }
}
