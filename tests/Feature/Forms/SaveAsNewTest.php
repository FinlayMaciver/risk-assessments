<?php

namespace Tests\Feature\Form;

use App\Models\Form;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\Risk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SaveAsNewTest extends TestCase
{
    public function testUserCanReplicateAGeneralForm()
    {
        Storage::fake('coshh');
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::create([
            'type' => 'General',
            'user_id' => $user2->id,
            'multi_user' => false,
            'title' => 'Form title',
            'management_unit' => 'Form unit',
            'review_date' => now()->format('Y-m-d'),
            'location' => 'Form location',
            'description' => 'Form description',
            'supervisor_id' => $supervisor->id,
        ]);

        $risk1 = Risk::create([
            'form_id' => $form->id,
            'hazard' => 'Risk 1 hazard',
            'consequences' => 'Risk 1 consequences',
            'likelihood_without' => Likelihood::inRandomOrder()->first()->id,
            'impact_without' => Impact::inRandomOrder()->first()->id,
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => Likelihood::inRandomOrder()->first()->id,
            'impact_with' => Impact::inRandomOrder()->first()->id,
        ]);
        $risk2 = Risk::create([
            'form_id' => $form->id,
            'hazard' => 'Risk 2 hazard',
            'consequences' => 'Risk 2 consequences',
            'likelihood_without' => Likelihood::inRandomOrder()->first()->id,
            'impact_without' => Impact::inRandomOrder()->first()->id,
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => Likelihood::inRandomOrder()->first()->id,
            'impact_with' => Impact::inRandomOrder()->first()->id,
        ]);

        $file1 = UploadedFile::fake()->image('test1.jpg');
        $file2 = UploadedFile::fake()->image('test2.jpg');

        $form->addFile($file1);
        $form->addFile($file2);

        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Replicate::class, ['id' => $form->id])
            ->assertSet('form.id', null)
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.title', 'Form title')
            ->assertSet('form.management_unit', 'Form unit')
            ->assertSet('form.location', 'Form location')
            ->assertSet('form.description', 'Form description')
            ->assertSet('form.supervisor_id', null)
            ->assertSet('form.review_date', null)
            ->assertSet('form.coshhSection.id', null)
            ->assertSet('form.risks.0.id', null)
            ->assertSet('form.risks.1.id', null)
            ->assertSet('form.files.0.id', null)
            ->assertSet('form.files.1.id', null)
            ->assertSet('form.files.0.original_filename', 'test1.jpg')
            ->assertSet('form.files.1.original_filename', 'test2.jpg');
    }
}
