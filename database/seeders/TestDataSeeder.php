<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\Hazard;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Route;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        $me = User::factory()->admin()->create([
            'forenames' => 'Finlay',
            'surname' => 'Mac',
            'email' => 'finlay.maciver@glasgow.ac.uk',
            'guid' => 'fmi9x',
        ]);

        Form::factory()->count(5)->create([
            'user_id' => $me->id,
        ]);
        Form::factory()->approved()->count(5)->create();
        Form::factory()->rejected()->count(5)->create();

        foreach (range(1, 10) as $i) {
            Form::factory()->create([
                "review_date" => now()->addDays(rand(1, 40)),
            ]);
        }

        Form::factory()->multiuser()->count(5)->create();
        Form::factory()->multiuser()->approved()->count(5)->create();
        Form::factory()->multiuser()->rejected()->count(5)->create();

        Form::factory()->chemical()->count(5)->create();
        Form::factory()->chemical()->approved()->count(5)->create();
        Form::factory()->chemical()->rejected()->count(5)->create();

        Form::factory()->chemical()->multiuser()->count(5)->create();
        Form::factory()->chemical()->multiuser()->approved()->count(5)->create();
        Form::factory()->chemical()->multiuser()->rejected()->count(5)->create();

        Form::factory()->biological()->count(5)->create();
        Form::factory()->biological()->approved()->count(5)->create();
        Form::factory()->biological()->rejected()->count(5)->create();

        Form::factory()->biological()->multiuser()->count(5)->create();
        Form::factory()->biological()->multiuser()->approved()->count(5)->create();
        Form::factory()->biological()->multiuser()->rejected()->count(5)->create();
    }
}
