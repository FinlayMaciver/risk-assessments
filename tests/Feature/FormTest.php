<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\FormRisk;
use App\Models\GeneralFormDetails;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class FormTest extends TestCase
{
    public function testHomePageShowsOnlyLoggedInUsersForms()
    {
        $user = User::factory()->create();
        $forms = Form::factory()->count(2)->create(['user_id' => $user->id]);
        $otherUserForm = Form::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee($forms[0]->title);
        $response->assertSee($forms[1]->title);
        $response->assertDontSee($otherUserForm->title);
    }

    public function testUserHasNoFormsSoSeesNoForms()
    {
        $user = User::factory()->create();
        $forms = Form::factory()->count(2)->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('You have not submitted any forms.');
        $response->assertDontSee($forms[0]->title);
        $response->assertDontSee($forms[1]->title);
    }

    public function testUserCanStartSubmittingANewGeneralForm()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('form.create', ['type' => 'General', 'multi' => false]));

        $response->assertStatus(200);
        $response->assertSee('Risk Assessment - General');
        $response->assertSee('Save');
    }

    public function testUserCanSubmitANewGeneralForm()
    {
        $user = User::factory()->create();
        $form = new Form([
            'type' => 'General',
            'user_id' => $user->id,
            'multi_user' => false
        ]);
        $form->risks->add(new FormRisk());

        $risks = [
            1 => new FormRisk([
                'description' => 'Risk 1 description',
                'severity' => 'Risk 1 severity',
                'control_measures' => 'Risk 1 control measures',
                'likelihood_with' => 'Risk 1 likelihood with',
                'likelihood_without' => 'Risk 1 likelihood without',
            ]),
            2 => new FormRisk([
                'description' => 'Risk 2 description',
                'severity' => 'Risk 2 severity',
                'control_measures' => 'Risk 2 control measures',
                'likelihood_with' => 'Risk 2 likelihood with',
                'likelihood_without' => 'Risk 2 likelihood without',
            ])
        ];

        $content = Livewire::actingAs($user)
        ->test(\App\Http\Livewire\Form\Partials\Content::class, ['form' => $form])
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.type', 'General')
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

            //General section
            ->set('form.general.chemicals_involved', 'Form chemicals involved')

            ->set('form.supervisor_id', null)
            ->set('form.lab_guardian_id', null);

        $riskForm = Livewire::actingAs($user)
        ->test(\App\Http\Livewire\Form\Partials\Risks::class, ['risks' => $form->risks])
        ->set('risks', $risks)
        ->call('update');

        $content->call('updateRisks', collect($risks))
        ->assertSet('form.risks', collect($risks))
        ->call('save');

        $savedForm = Form::where('title', 'Form title')->first();

        $this->assertDatabaseHas('forms', [
            'user_id' => $user->id,
            'type' => 'General',
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

            'supervisor_id' => null,
            'lab_guardian_id' => null,
        ]);

        $this->assertDatabaseHas('general_form_details', [
            'form_id' => $savedForm->id,
            'chemicals_involved' => 'Form chemicals involved'
        ]);

        $this->assertDatabaseHas('form_risks', [
            'form_id' => $savedForm->id,
            'description' => 'Risk 1 description',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);

        $this->assertDatabaseHas('form_risks', [
            'form_id' => $savedForm->id,
            'description' => 'Risk 2 description',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);
    }

    public function testUserCanEditAndSaveAGeneralForm()
    {
        $user = User::factory()->create();
        $form = Form::create([
            'type' => 'General',
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

            'supervisor_id' => null,
            'lab_guardian_id' => null,
        ]);

        $risk1 = FormRisk::create([
            'form_id' => $form->id,
            'description' => 'Risk 1 description',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);
        $risk2 = FormRisk::create([
            'form_id' => $form->id,
            'description' => 'Risk 2 description',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);

        $generalSection = GeneralFormDetails::create([
            'form_id' => $form->id,
            'chemicals_involved' => 'Form chemicals involved'
        ]);

        $form->load('general', 'risks');

        $content = Livewire::actingAs($user)
        ->test(\App\Http\Livewire\Form\Partials\Content::class, ['form' => $form])
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.type', 'General')
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

            //General section
            ->assertSet('form.general.chemicals_involved', 'Form chemicals involved')

            ->assertSet('form.supervisor_id', null)
            ->assertSet('form.lab_guardian_id', null);

        $riskForm = Livewire::actingAs($user)
        ->test(\App\Http\Livewire\Form\Partials\Risks::class, ['risks' => $form->risks])
        ->set('risks', $form->risks);

        $content->set('form.title', 'New title')
            ->set('form.general.chemicals_involved', 'New chemicals involved')
            ->call('save');

        $this->assertDatabaseHas('forms', [
            'user_id' => $user->id,
            'type' => 'General',
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
            'lab_guardian_id' => null,
        ]);

        $this->assertDatabaseHas('general_form_details', [
            'form_id' => $form->id,
            'chemicals_involved' => 'New chemicals involved'
        ]);

        $this->assertDatabaseHas('form_risks', [
            'form_id' => $form->id,
            'description' => 'Risk 1 description',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);

        $this->assertDatabaseHas('form_risks', [
            'form_id' => $form->id,
            'description' => 'Risk 2 description',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);
    }
}
