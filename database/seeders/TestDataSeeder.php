<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\Hazard;
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
        $classifications = ['Very toxic',
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

        $coshhAdmin = User::factory()->coshhAdmin()->create([
            'forenames' => 'Coshh',
            'surname' => 'Admin',
            'guid' => 'coshhadmin',
        ]);

        Form::factory()->count(5)->create([
            'user_id' => $me->id,
        ]);
        Form::factory()->approved()->count(5)->create();
        Form::factory()->rejected()->count(5)->create();

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
