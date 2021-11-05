<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\MicroOrganism;
use App\Models\Risk;
use App\Models\Substance;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Livewire;
use Tests\TestCase;

class BiologicalFormTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    public function testUserCanStartSubmittingANewBiologicalForm()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('form.create', ['type' => 'Biological', 'multi' => false]));

        $response->assertStatus(200);
        $response->assertSee('Risk Assessment - Biological');
        $response->assertSee('Save');
    }

    public function testUserCanSubmitANewBiologicalForm()
    {
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $form = new Form([
            'type' => 'Biological',
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

        $form->substances = new Collection([
            1 => new Substance([
                'substance' => 'Substance 1',
                'quantity' => 'Substance 1 quantity',
                'single_acute_effect' => 'Substance 1 single acute effect',
                'repeated_low_effect' => 'Substance 1 repeated low effect',
            ]),
            2 => new Substance([
                'substance' => 'Substance 2',
                'quantity' => 'Substance 2 quantity',
                'single_acute_effect' => 'Substance 2 single acute effect',
                'repeated_low_effect' => 'Substance 2 repeated low effect',
            ])
        ]);

        $form->microOrganisms = new Collection([
            1 => new MicroOrganism([
                'micro_organism' => 'Micro-organism 1',
                'classification' => 'Micro-organism 1 quantity',
                'risk' => 'ACDP Class 1',
                'single_acute_effect' => 'Micro-organism 1 single acute effect',
                'repeated_low_effect' => 'Micro-organism 1 repeated low effect',
            ]),
            2 => new MicroOrganism([
                'micro_organism' => 'Micro-organism 2',
                'classification' => 'Micro-organism 2 quantity',
                'risk' => 'ACDP Class 2',
                'single_acute_effect' => 'Micro-organism 2 single acute effect',
                'repeated_low_effect' => 'Micro-organism 2 repeated low effect',
            ])
        ]);

        $content = Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Partials\Content::class, ['form' => $form])
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.type', 'Biological')
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
            ->set('form.lab_guardian_id', $labGuardian->id)

            ->set('substances.0.hazard_ids', [1, 2])
            ->set('substances.0.route_ids', [1, 2])

            ->set('substances.1.hazard_ids', [3, 5])
            ->set('substances.1.route_ids', [3, 5])

            ->set('microOrganisms.0.route_ids', [1, 2])
            ->set('microOrganisms.1.route_ids', [3, 5]);

        $content->call('save');

        $savedForm = Form::where('title', 'Form title')->first();

        $this->assertDatabaseHas('forms', [
            'user_id' => $user->id,
            'type' => 'Biological',
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
        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => Substance::where('substance', 'Substance 1')->first()->id,
            'route_id' => 1,
        ]);
        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => Substance::where('substance', 'Substance 1')->first()->id,
            'route_id' => 2,
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
        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => Substance::where('substance', 'Substance 2')->first()->id,
            'route_id' => 3,
        ]);
        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => Substance::where('substance', 'Substance 2')->first()->id,
            'route_id' => 5,
        ]);

        $this->assertDatabaseHas('micro_organisms', [
            'form_id' => $savedForm->id,
            'micro_organism' => 'Micro-organism 1',
            'classification' => 'Micro-organism 1 quantity',
            'risk' => 'ACDP Class 1',
            'single_acute_effect' => 'Micro-organism 1 single acute effect',
            'repeated_low_effect' => 'Micro-organism 1 repeated low effect',
        ]);

        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => MicroOrganism::where('micro_organism', 'Micro-organism 1')->first()->id,
            'route_id' => 1,
        ]);
        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => MicroOrganism::where('micro_organism', 'Micro-organism 1')->first()->id,
            'route_id' => 2,
        ]);

        $this->assertDatabaseHas('micro_organisms', [
            'form_id' => $savedForm->id,
            'micro_organism' => 'Micro-organism 2',
            'classification' => 'Micro-organism 2 quantity',
            'risk' => 'ACDP Class 2',
            'single_acute_effect' => 'Micro-organism 2 single acute effect',
            'repeated_low_effect' => 'Micro-organism 2 repeated low effect',
        ]);

        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => MicroOrganism::where('micro_organism', 'Micro-organism 2')->first()->id,
            'route_id' => 3,
        ]);
        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => MicroOrganism::where('micro_organism', 'Micro-organism 2')->first()->id,
            'route_id' => 5,
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
    }

    public function testUserCanEditAndSaveBiologicalForm()
    {
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $form = Form::create([
            'type' => 'Biological',
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

        $substance1 = Substance::create([
            'form_id' => $form->id,
            'substance' => 'Substance 1',
            'quantity' => 'Substance 1 quantity',
            'single_acute_effect' => 'Substance 1 single acute effect',
            'repeated_low_effect' => 'Substance 1 repeated low effect',
        ]);
        $substance1->hazards()->attach([1,2]);
        $substance1->routes()->attach([1,2]);

        $substance2 = Substance::create([
            'form_id' => $form->id,
            'substance' => 'Substance 2',
            'quantity' => 'Substance 2 quantity',
            'single_acute_effect' => 'Substance 2 single acute effect',
            'repeated_low_effect' => 'Substance 2 repeated low effect',
        ]);
        $substance2->hazards()->attach([3,5]);
        $substance2->routes()->attach([3,5]);

        $microOrganism1 = MicroOrganism::create([
            'form_id' => $form->id,
            'micro_organism' => 'Micro-organism 1',
            'classification' => 'Micro-organism 1 quantity',
            'risk' => 'ACDP Class 1',
            'single_acute_effect' => 'Micro-organism 1 single acute effect',
            'repeated_low_effect' => 'Micro-organism 1 repeated low effect',
        ]);
        $microOrganism1->routes()->attach([1,2]);

        $microOrganism2 = MicroOrganism::create([
            'form_id' => $form->id,
            'micro_organism' => 'Micro-organism 2',
            'classification' => 'Micro-organism 2 quantity',
            'risk' => 'ACDP Class 2',
            'single_acute_effect' => 'Micro-organism 2 single acute effect',
            'repeated_low_effect' => 'Micro-organism 2 repeated low effect',
        ]);
        $microOrganism2->routes()->attach([3,5]);

        $content = Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Partials\Content::class, [
                'form' => $form,
                'substances' => $form->substances,
                'microOrganisms' => $form->microOrganisms,
            ])
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.type', 'Biological')
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
        $content->call('deleteRisk', 1);

        //Substances - delete 1
        $content->call('deleteSubstance', 1);

        //Micro-organisms - delete 1
        $content->call('deleteMicroOrganism', 1);

        $content
            ->set('form.title', 'New title')
            ->set('form.supervisor_id', null)
            ->call('save');

        $this->assertEquals($form->fresh()->risks->count(), 1);
        $this->assertEquals($form->fresh()->substances->count(), 1);
        $this->assertEquals($form->fresh()->microOrganisms->count(), 1);

        $this->assertDatabaseHas('forms', [
            'user_id' => $user->id,
            'type' => 'Biological',
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

        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => Substance::where('substance', 'Substance 1')->first()->id,
            'route_id' => 1,
        ]);
        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => Substance::where('substance', 'Substance 1')->first()->id,
            'route_id' => 2,
        ]);

        $this->assertDatabaseMissing('substances', [
            'form_id' => $form->id,
            'substance' => 'Substance 2',
            'quantity' => 'Substance 2 quantity',
            'single_acute_effect' => 'Substance 2 single acute effect',
            'repeated_low_effect' => 'Substance 2 repeated low effect',
        ]);

        $this->assertDatabaseHas('micro_organisms', [
            'form_id' => $form->id,
            'micro_organism' => 'Micro-organism 1',
            'classification' => 'Micro-organism 1 quantity',
            'risk' => 'ACDP Class 1',
            'single_acute_effect' => 'Micro-organism 1 single acute effect',
            'repeated_low_effect' => 'Micro-organism 1 repeated low effect',
        ]);

        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => MicroOrganism::where('micro_organism', 'Micro-organism 1')->first()->id,
            'route_id' => 1,
        ]);
        $this->assertDatabaseHas('substance_routes', [
            'substance_id' => MicroOrganism::where('micro_organism', 'Micro-organism 1')->first()->id,
            'route_id' => 2,
        ]);

        $this->assertDatabaseMissing('micro_organisms', [
            'form_id' => $form->id,
            'micro_organism' => 'Micro-organism 2',
            'classification' => 'Micro-organism 2 quantity',
            'risk' => 'ACDP Class 2',
            'single_acute_effect' => 'Micro-organism 2 single acute effect',
            'repeated_low_effect' => 'Micro-organism 2 repeated low effect',
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
    }
}
