<?php

namespace Tests\Feature\Forms;

use App\Models\Form;
use App\Models\GeneralFormDetails;
use App\Models\Risk;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class GeneralFormTest extends TestCase
{
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
        Storage::fake('coshh');
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $form = new Form([
            'type' => 'General',
            'user_id' => $user->id,
            'multi_user' => false
        ]);

        $form->risks = new Collection([
            1 => new Risk([
                'risk' => 'Risk 1 risk',
                'severity' => 'Risk 1 severity',
                'control_measures' => 'Risk 1 control measures',
                'likelihood_with' => 'Risk 1 likelihood with',
                'likelihood_without' => 'Risk 1 likelihood without',
            ]),
            2 => new Risk([
                'risk' => 'Risk 2 risk',
                'severity' => 'Risk 2 severity',
                'control_measures' => 'Risk 2 control measures',
                'likelihood_with' => 'Risk 2 likelihood with',
                'likelihood_without' => 'Risk 2 likelihood without',
            ])
        ]);

        $file = UploadedFile::fake()->image('test.jpg');

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
            ->set('section.chemicals_involved', 'Form chemicals involved')

            ->set('form.supervisor_id', $supervisor->id)
            ->set('form.lab_guardian_id', $labGuardian->id);

        $content->set('newFiles.0', $file);
        $content->call('save');

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

            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $this->assertDatabaseHas('general_form_details', [
            'form_id' => $savedForm->id,
            'chemicals_involved' => 'Form chemicals involved'
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $savedForm->id,
            'risk' => 'Risk 1 risk',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $savedForm->id,
            'risk' => 'Risk 2 risk',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);

        $this->assertDatabaseHas('files', [
            'form_id' => $savedForm->id,
            'original_filename' => 'test.jpg'
        ]);

        Storage::disk('coshh')->assertExists('form_1/file_1.dat');
    }

    public function testUserCanEditAndSaveAGeneralForm()
    {
        Storage::fake('coshh');
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
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

            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $risk1 = Risk::create([
            'form_id' => $form->id,
            'risk' => 'Risk 1 risk',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);
        $risk2 = Risk::create([
            'form_id' => $form->id,
            'risk' => 'Risk 2 risk',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);

        $file1 = UploadedFile::fake()->image('test1.jpg');
        $file2 = UploadedFile::fake()->image('test2.jpg');

        $form->addFile($file1);
        $form->addFile($file2);

        $generalSection = GeneralFormDetails::create([
            'form_id' => $form->id,
            'chemicals_involved' => 'Form chemicals involved'
        ]);

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
            ->assertSet('section.chemicals_involved', 'Form chemicals involved')

            ->assertSet('form.supervisor_id', $supervisor->id)
            ->assertSet('form.lab_guardian_id', $labGuardian->id);


        //Risks - deleting one
        $content->call('deleteRisk', 1);

        //Files - deleting one
        $files = $form->fresh()->files;
        $content->set('files', $files->forget(1));

        $content->set('form.title', 'New title')
            ->set('section.chemicals_involved', 'New chemicals involved')
            ->set('form.supervisor_id', null)
            ->call('save');

        $this->assertEquals($form->fresh()->risks->count(), 1);
        $this->assertEquals($form->fresh()->files->count(), 1);

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
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $this->assertDatabaseHas('general_form_details', [
            'form_id' => $form->id,
            'chemicals_involved' => 'New chemicals involved'
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $form->id,
            'risk' => 'Risk 1 risk',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);

        $this->assertDatabaseMissing('risks', [
            'form_id' => $form->id,
            'risk' => 'Risk 2 risk',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);

        $this->assertDatabaseHas('files', [
            'form_id' => $form->id,
            'original_filename' => 'test1.jpg'
        ]);

        $this->assertDatabaseMissing('files', [
            'form_id' => $form->id,
            'original_filename' => 'test2.jpg'
        ]);

        Storage::disk('coshh')->assertExists('form_1/file_1.dat');
        Storage::disk('coshh')->assertMissing('form_1/file_2.dat');
    }

    /** @test */
    public function testUserCanViewAGeneralForm()
    {
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
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

            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $risk1 = Risk::create([
            'form_id' => $form->id,
            'risk' => 'Risk 1 risk',
            'severity' => 'Risk 1 severity',
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 'Risk 1 likelihood with',
            'likelihood_without' => 'Risk 1 likelihood without',
        ]);
        $risk2 = Risk::create([
            'form_id' => $form->id,
            'risk' => 'Risk 2 risk',
            'severity' => 'Risk 2 severity',
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 'Risk 2 likelihood with',
            'likelihood_without' => 'Risk 2 likelihood without',
        ]);

        $generalSection = GeneralFormDetails::create([
            'form_id' => $form->id,
            'chemicals_involved' => 'Form chemicals involved'
        ]);

        $response = $this->actingAs($user)->get(route('form.show', $form->id));

        $response->assertStatus(200);
        $response->assertSee($user->full_name);
        $response->assertSee($supervisor->full_name);
        $response->assertSee($labGuardian->full_name);
        $response->assertSee('General');
        $response->assertSee('Form title');
        $response->assertSee('Form location');
        $response->assertSee('Form description');
        $response->assertSee('Form control measures');
        $response->assertSee('Form work site');
        $response->assertSee('Form further risks');
        $response->assertSee('Form disposal methods');
        $response->assertSee('Form other protection');
        $response->assertSee('Form other emergency');
        $response->assertSee('Form inform other');
        $response->assertSee('Risk 1 risk');
        $response->assertSee('Risk 1 severity');
        $response->assertSee('Risk 1 control measures');
        $response->assertSee('Risk 1 likelihood with');
        $response->assertSee('Risk 1 likelihood without');
        $response->assertSee('Risk 2 risk');
        $response->assertSee('Risk 2 severity');
        $response->assertSee('Risk 2 control measures');
        $response->assertSee('Risk 2 likelihood with');
        $response->assertSee('Risk 2 likelihood without');
        $response->assertSee('Form chemicals involved');

        $response->assertDontSee('Hazardous substances involved');
        $response->assertDontSee('Hazards of micro-organisms involved');
    }
}
