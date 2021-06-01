<?php

namespace Database\Seeders;

use App\Models\Hazard;
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
            'Teratogen'
        ];

        foreach ($classifications as $classification) {
            Hazard::factory()->create(['title' => $classification]);
        }

        User::factory()->admin()->create([
            'forenames' => 'Finlay',
            'surname' => 'Mac',
            'email' => 'finlay.mac@example.com',
            'guid' => 'fmi9x',
        ]);
    }
}
