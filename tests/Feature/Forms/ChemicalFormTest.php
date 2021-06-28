<?php

namespace Tests\Feature\Forms;

use App\Models\Form;
use App\Models\Risk;
use App\Models\Substance;
use App\Models\SubstanceHazard;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Livewire;
use Tests\TestCase;

class ChemicalFormTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    public function testUserCanStartSubmittingANewChemicalForm()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('form.create', ['type' => 'Chemical', 'multi' => false]));

        $response->assertStatus(200);
        $response->assertSee('Risk Assessment - Chemical');
        $response->assertSee('Save');
    }

    public function testUserCanSubmitANewChemicalForm()
    {
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $form = new Form([
            'type' => 'Chemical',
            'user_id' => $user->id,
            'multi_user' => false
        ]);

        $risks = new Collection([
            1 => new Risk([
                'description' => 'Risk 1 description',
                'severity' => 'Risk 1 severity',
                'control_measures' => 'Risk 1 control measures',
                'likelihood_with' => 'Risk 1 likelihood with',
                'likelihood_without' => 'Risk 1 likelihood without',
             ]),
            2 => new Risk([
                'description' => 'Risk 2 description',
                'severity' => 'Risk 2 severity',
                'control_measures' => 'Risk 2 control measures',
                'likelihood_with' => 'Risk 2 likelihood with',
                'likelihood_without' => 'Risk 2 likelihood without',
            ])
        ]);

        $substances = new Collection([
            1 => new Substance([
                'substance' => 'Substance 1',
                'quantity' => 'Substance 1 quantity',

                'single_acute_effect' => 'Substance 1 single acute effect',
                'repeated_low_effect' => 'Substance 1 repeated low effect',
                'hazard_ids' => [1, 2],
            ]),
            2 => new Substance([
                'substance' => 'Substance 2',
                'quantity' => 'Substance 2 quantity',

                'single_acute_effect' => 'Substance 2 single acute effect',
                'repeated_low_effect' => 'Substance 2 repeated low effect',
                'hazard_ids' => [3, 5]
            ])
        ]);

        $content = Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Partials\Content::class, ['form' => $form])
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.type', 'Chemical')
            ->assertSet('form.multi_user', false)
            ->set('form.title', 'Form title')
            ->set('form.location', 'Form location')
            ->set('form.description', 'Form description')
            ->set('form.control_measures', 'Form control measures')
            ->set('form.work_site', 'Form work site')
            ->set('form.further_risks', 'Form further risks')
            ->set('form.disposal_methods', 'Form disposal methods')
            ->set('form.eye_protection', true)
            ->set('form.face_protection', true)
            ->set('form.hand_protection', true)
            ->set('form.foot_protection', true)
            ->set('form.respiratory_protection', true)
            ->set('form.other_protection', 'Form other protection')
            ->set('form.instructions', true)
            ->set('form.spill_neutralisation', true)
            ->set('form.eye_irrigation', true)
            ->set('form.body_shower', true)
            ->set('form.first_aid', true)
            ->set('form.breathing_apparatus', true)
            ->set('form.external_services', true)
            ->set('form.poison_antidote', true)
            ->set('form.other_emergency', 'Form other emergency')
            ->set('form.routine_approval', true)
            ->set('form.specific_approval', true)
            ->set('form.personal_supervision', true)

            //Monitoring
            ->set('form.airborne_monitoring', true)
            ->set('form.biological_monitoring', true)

            //Informing
            ->set('form.inform_lab_occupants', true)
            ->set('form.inform_cleaners', true)
            ->set('form.inform_contractors', true)
            ->set('form.inform_other', 'Form inform other')

            ->set('form.supervisor_id', $supervisor->id)
            ->set('form.lab_guardian_id', $labGuardian->id);

        //Risks
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Partials\Risks::class, ['risks' => $form->risks])
            ->set('risks', $risks)
            ->call('update')
            ->assertEmitted('risksUpdated');

        //Substances
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Partials\Substances::class, ['substances' => $form->substances])
            ->set('substances', $substances)
            ->call('update')
            ->assertEmitted('substancesUpdated');

        $content
            ->call('risksUpdated', $risks)
            ->call('substancesUpdated', $substances)
            ->call('save');

        $savedForm = Form::where('title', 'Form title')->first();

        $this->assertDatabaseHas('forms', [
            'user_id' => $user->id,
            'type' => 'Chemical',
            'multi_user' => false,
            'title' => 'Form title',
            'location' => 'Form location',
            'description' => 'Form description',
            'control_measures' => 'Form control measures',
            'work_site' => 'Form work site',
            'further_risks' => 'Form further risks',
            'disposal_methods' => 'Form disposal methods',
            'eye_protection' => true,
            'face_protection' => true,
            'hand_protection' => true,
            'foot_protection' => true,
            'respiratory_protection' => true,
            'other_protection' => 'Form other protection',
            'instructions' => true,
            'spill_neutralisation' => true,
            'eye_irrigation' => true,
            'body_shower' => true,
            'first_aid' => true,
            'breathing_apparatus' => true,
            'external_services' => true,
            'poison_antidote' => true,
            'other_emergency' => 'Form other emergency',
            'routine_approval' => true,
            'specific_approval' => true,
            'personal_supervision' => true,

            //Monitoring
            'airborne_monitoring' => true,
            'biological_monitoring' => true,

            //Informing
            'inform_lab_occupants' => true,
            'inform_cleaners' => true,
            'inform_contractors' => true,
            'inform_other' => 'Form inform other',

            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $this->assertDatabaseHas('substances', [
            'form_id' => $savedForm->id,
            'substance' => 'Substance 1',
            'quantity' => 'Substance 1 quantity',
            'single_acute_effect' => 'Substance 1 single acute effect',
            'repeated_low_effect' => 'Substance 1 repeated low effect',
        ]);

        $this->assertDatabaseHas('substance_hazards', [
            'substance_id' => Substance::where('substance', 'Substance 1')->first()->id,
            'hazard_id' => 1,
        ]);
        $this->assertDatabaseHas('substance_hazards', [
            'substance_id' => Substance::where('substance', 'Substance 1')->first()->id,
            'hazard_id' => 2,
        ]);

        $this->assertDatabaseHas('substances', [
            'form_id' => $savedForm->id,
            'substance' => 'Substance 2',
            'quantity' => 'Substance 2 quantity',
            'single_acute_effect' => 'Substance 2 single acute effect',
            'repeated_low_effect' => 'Substance 2 repeated low effect',
        ]);

        $this->assertDatabaseHas('substance_hazards', [
            'substance_id' => Substance::where('substance', 'Substance 2')->first()->id,
            'hazard_id' => 3,
        ]);
        $this->assertDatabaseHas('substance_hazards', [
            'substance_id' => Substance::where('substance', 'Substance 2')->first()->id,
            'hazard_id' => 5,
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $savedForm->id,
            'description' => 'Risk 1 description',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $savedForm->id,
            'description' => 'Risk 2 description',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);
    }

    public function testUserCanEditAndSaveChemicalForm()
    {
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $form = Form::create([
            'type' => 'Chemical',
            'user_id' => $user->id,
            'multi_user' => false,
            'title' => 'Form title',
            'location' => 'Form location',
            'description' => 'Form description',
            'control_measures' => 'Form control measures',
            'work_site' => 'Form work site',
            'further_risks' => 'Form further risks',
            'disposal_methods' => 'Form disposal methods',
            'eye_protection' => true,
            'face_protection' => true,
            'hand_protection' => true,
            'foot_protection' => true,
            'respiratory_protection' => true,
            'other_protection' => 'Form other protection',
            'instructions' => true,
            'spill_neutralisation' => true,
            'eye_irrigation' => true,
            'body_shower' => true,
            'first_aid' => true,
            'breathing_apparatus' => true,
            'external_services' => true,
            'poison_antidote' => true,
            'other_emergency' => 'Form other emergency',
            'routine_approval' => true,
            'specific_approval' => true,
            'personal_supervision' => true,

            //Monitoring
            'airborne_monitoring' => true,
            'biological_monitoring' => true,

            //Informing
            'inform_lab_occupants' => true,
            'inform_cleaners' => true,
            'inform_contractors' => true,
            'inform_other' => 'Form inform other',

            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $risk1 = Risk::create([
            'form_id' => $form->id,
            'description' => 'Risk 1 description',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);
        $risk2 = Risk::create([
            'form_id' => $form->id,
            'description' => 'Risk 2 description',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);

        $substance1 = Substance::create([
            'form_id' => $form->id,
            'substance' => 'Substance 1',
            'quantity' => 'Substance 1 quantity',
            'single_acute_effect' => 'Substance 1 single acute effect',
            'repeated_low_effect' => 'Substance 1 repeated low effect',
        ]);
        $substance1->hazards()->attach([1,2]);

        $substance2 = Substance::create([
            'form_id' => $form->id,
            'substance' => 'Substance 2',
            'quantity' => 'Substance 2 quantity',
            'single_acute_effect' => 'Substance 2 single acute effect',
            'repeated_low_effect' => 'Substance 2 repeated low effect',
        ]);
        $substance2->hazards()->attach([3,5]);

        $content = Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Partials\Content::class, ['form' => $form, 'substances' => $form->substances->load('hazards')])
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.type', 'Chemical')
            ->assertSet('form.multi_user', false)
            ->assertSet('form.title', 'Form title')
            ->assertSet('form.location', 'Form location')
            ->assertSet('form.description', 'Form description')
            ->assertSet('form.control_measures', 'Form control measures')
            ->assertSet('form.work_site', 'Form work site')
            ->assertSet('form.further_risks', 'Form further risks')
            ->assertSet('form.disposal_methods', 'Form disposal methods')
            ->assertSet('form.eye_protection', true)
            ->assertSet('form.face_protection', true)
            ->assertSet('form.hand_protection', true)
            ->assertSet('form.foot_protection', true)
            ->assertSet('form.respiratory_protection', true)
            ->assertSet('form.other_protection', 'Form other protection')
            ->assertSet('form.instructions', true)
            ->assertSet('form.spill_neutralisation', true)
            ->assertSet('form.eye_irrigation', true)
            ->assertSet('form.body_shower', true)
            ->assertSet('form.first_aid', true)
            ->assertSet('form.breathing_apparatus', true)
            ->assertSet('form.external_services', true)
            ->assertSet('form.poison_antidote', true)
            ->assertSet('form.other_emergency', 'Form other emergency')
            ->assertSet('form.routine_approval', true)
            ->assertSet('form.specific_approval', true)
            ->assertSet('form.personal_supervision', true)

            //Monitoring
            ->assertSet('form.airborne_monitoring', true)
            ->assertSet('form.biological_monitoring', true)

            //Informing
            ->assertSet('form.inform_lab_occupants', true)
            ->assertSet('form.inform_cleaners', true)
            ->assertSet('form.inform_contractors', true)
            ->assertSet('form.inform_other', 'Form inform other')

            ->assertSet('form.supervisor_id', $supervisor->id)
            ->assertSet('form.lab_guardian_id', $labGuardian->id);

        //Risks - deleting one
        $risks = $form->risks;
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Partials\Risks::class, ['risks' => $risks])
            ->call('delete', 1)
            ->assertEmitted('risksUpdated')
            ->assertCount('risks', 1);

        //Substances - delete 1
        $substances = $form->substances;
        $substances = $substances->each(function ($substance) {
            $substance['hazard_ids'] = $substance->hazards->pluck('id');
        });
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Partials\Substances::class, ['substances' => $substances])
            ->call('delete', 1)
            ->assertEmitted('substancesUpdated')
            ->assertCount('substances', 1);

        $content
            ->set('risks', $risks->forget(1))
            ->set('substances', $substances->forget(1))
            ->set('form.title', 'New title')
            ->set('form.supervisor_id', null)
            ->call('save');

        $this->assertEquals($form->fresh()->risks->count(), 1);
        $this->assertEquals($form->fresh()->substances->count(), 1);

        $this->assertDatabaseHas('forms', [
            'user_id' => $user->id,
            'type' => 'Chemical',
            'multi_user' => false,
            'title' => 'New title',
            'location' => 'Form location',
            'description' => 'Form description',
            'control_measures' => 'Form control measures',
            'work_site' => 'Form work site',
            'further_risks' => 'Form further risks',
            'disposal_methods' => 'Form disposal methods',
            'eye_protection' => true,
            'face_protection' => true,
            'hand_protection' => true,
            'foot_protection' => true,
            'respiratory_protection' => true,
            'other_protection' => 'Form other protection',
            'instructions' => true,
            'spill_neutralisation' => true,
            'eye_irrigation' => true,
            'body_shower' => true,
            'first_aid' => true,
            'breathing_apparatus' => true,
            'external_services' => true,
            'poison_antidote' => true,
            'other_emergency' => 'Form other emergency',
            'routine_approval' => true,
            'specific_approval' => true,
            'personal_supervision' => true,

            //Monitoring
            'airborne_monitoring' => true,
            'biological_monitoring' => true,

            //Informing
            'inform_lab_occupants' => true,
            'inform_cleaners' => true,
            'inform_contractors' => true,
            'inform_other' => 'Form inform other',

            'supervisor_id' => null,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $this->assertDatabaseHas('substances', [
            'form_id' => $form->id,
            'substance' => 'Substance 1',
            'quantity' => 'Substance 1 quantity',
            'single_acute_effect' => 'Substance 1 single acute effect',
            'repeated_low_effect' => 'Substance 1 repeated low effect',
        ]);

        $this->assertDatabaseHas('substance_hazards', [
            'substance_id' => Substance::where('substance', 'Substance 1')->first()->id,
            'hazard_id' => 1,
        ]);
        $this->assertDatabaseHas('substance_hazards', [
            'substance_id' => Substance::where('substance', 'Substance 1')->first()->id,
            'hazard_id' => 2,
        ]);

        $this->assertDatabaseMissing('substances', [
            'form_id' => $form->id,
            'substance' => 'Substance 2',
            'quantity' => 'Substance 2 quantity',
            'single_acute_effect' => 'Substance 2 single acute effect',
            'repeated_low_effect' => 'Substance 2 repeated low effect',
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $form->id,
            'description' => 'Risk 1 description',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);

        $this->assertDatabaseMissing('risks', [
            'form_id' => $form->id,
            'description' => 'Risk 2 description',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);
    }
}
