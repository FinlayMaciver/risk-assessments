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

        //Forms for current user
        Form::factory()->count(5)->create(['user_id' => $me->id]);
        Form::factory()->chemical()->count(5)->create(['user_id' => $me->id]);
        Form::factory()->biological()->count(5)->create(['user_id' => $me->id]);
        Form::factory()->rejected()->count(5)->create();
        foreach (range(1, 10) as $i) {
            Form::factory()->create([
                "review_date" => now()->addDays(rand(1, 40)),
            ]);
        }

        //Forms for current user as supervisor
        Form::factory()->count(5)->create(['supervisor_id' => $me->id]);
        Form::factory()->approved()->count(5)->create(['supervisor_id' => $me->id]);

        //Forms for current user as reviewer, approved and awaiting
        $reviewerApproved = Form::factory()->approved()->count(3)->create();
        $reviewerApproved[0]->reviewers()->syncWithPivotValues($me, ['approved' => true], false);
        $reviewerAwaiting = Form::factory()->count(3)->create();
        $reviewerAwaiting[0]->reviewers()->syncWithPivotValues($me, ['approved' => null], false);

        //Multiuser forms with current user attached
        Form::factory()->multiuser()->count(5)->create();
        $approvedMulti = Form::factory()->multiuser()->approved()->count(5)->create();
        $approvedMulti[0]->users()->attach($me);
        $approvedMulti[2]->users()->attach($me);
        $approvedMulti[4]->users()->attach($me);
        Form::factory()->multiuser()->rejected()->count(5)->create();

        //Archived froms
        Form::factory()->archived()->count(5)->create();

        //Additional forms
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
