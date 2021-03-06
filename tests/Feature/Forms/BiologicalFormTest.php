<?php

namespace Tests\Feature;

use App\Models\CoshhFormDetails;
use App\Models\Form;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\MicroOrganism;
use App\Models\Risk;
use App\Models\Substance;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Livewire;
use Tests\TestCase;

class BiologicalFormTest extends TestCase
{
    public function testUserCanSubmitANewBiologicalForm()
    {
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = new Form([
            'type' => 'Biological',
            'user_id' => $user->id,
            'multi_user' => false,
        ]);

        $form->risks = new Collection([
            1 => new Risk([
                'hazard' => 'Risk 1 hazard',
                'consequences' => 'Risk 1 consequences',
                'likelihood_without' => Likelihood::inRandomOrder()->first()->id,
                'impact_without' => Impact::inRandomOrder()->first()->id,
                'control_measures' => 'Risk 1 control measures',
                'likelihood_with' => Likelihood::inRandomOrder()->first()->id,
                'impact_with' => Impact::inRandomOrder()->first()->id,
            ]),
            2 => new Risk([
                'hazard' => 'Risk 2 hazard',
                'consequences' => 'Risk 2 consequences',
                'likelihood_without' => Likelihood::inRandomOrder()->first()->id,
                'impact_without' => Impact::inRandomOrder()->first()->id,
                'control_measures' => 'Risk 2 control measures',
                'likelihood_with' => Likelihood::inRandomOrder()->first()->id,
                'impact_with' => Impact::inRandomOrder()->first()->id,
            ]),
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
            ]),
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
            ]),
        ]);

        $content = Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Form\Partials\Content::class, ['form' => $form])
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.type', 'Biological')
            ->assertSet('form.multi_user', false)
            ->set('form.title', 'Form title')
            ->set('form.management_unit', 'Form unit')
            ->set('form.location', 'Form location')
            ->set('form.review_date', '2023-01-01')
            ->set('form.description', 'Form description')
            ->set('coshhSection.control_measures', 'Form control measures')
            ->set('coshhSection.work_site', 'Form work site')
            ->set('coshhSection.further_risks', 'Form further risks')
            ->set('coshhSection.disposal_methods', 'Form disposal methods')
            ->set('coshhSection.eye_protection', true)
            ->set('coshhSection.face_protection', true)
            ->set('coshhSection.hand_protection', true)
            ->set('coshhSection.foot_protection', true)
            ->set('coshhSection.respiratory_protection', true)
            ->set('coshhSection.other_protection', 'Form other protection')
            ->set('coshhSection.instructions', true)
            ->set('coshhSection.spill_neutralisation', true)
            ->set('coshhSection.eye_irrigation', true)
            ->set('coshhSection.body_shower', true)
            ->set('coshhSection.first_aid', true)
            ->set('coshhSection.breathing_apparatus', true)
            ->set('coshhSection.external_services', true)
            ->set('coshhSection.poison_antidote', true)
            ->set('coshhSection.other_emergency', 'Form other emergency')
            ->set('coshhSection.routine_approval', true)
            ->set('coshhSection.specific_approval', true)
            ->set('coshhSection.personal_supervision', true)

            //Monitoring
            ->set('coshhSection.airborne_monitoring', true)
            ->set('coshhSection.biological_monitoring', true)

            //Informing
            ->set('coshhSection.inform_lab_occupants', true)
            ->set('coshhSection.inform_cleaners', true)
            ->set('coshhSection.inform_contractors', true)
            ->set('coshhSection.inform_other', 'Form inform other')

            ->set('form.supervisor_id', $supervisor->id);

        $content->call('save');

        $savedForm = Form::where('title', 'Form title')->first();

        $this->assertDatabaseHas('forms', [
            'user_id' => $user->id,
            'type' => 'Biological',
            'multi_user' => false,
            'title' => 'Form title',
            'management_unit' => 'Form unit',
            'review_date' => '2023-01-01',
            'location' => 'Form location',
            'description' => 'Form description',
            'supervisor_id' => $supervisor->id,
        ]);

        $this->assertDatabaseHas('coshh_form_details', [
            'form_id' => $savedForm->id,
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
        ]);

        $this->assertDatabaseHas('substances', [
            'form_id' => $savedForm->id,
            'substance' => 'Substance 1',
            'quantity' => 'Substance 1 quantity',
            'single_acute_effect' => 'Substance 1 single acute effect',
            'repeated_low_effect' => 'Substance 1 repeated low effect',
        ]);

        $this->assertDatabaseHas('substances', [
            'form_id' => $savedForm->id,
            'substance' => 'Substance 2',
            'quantity' => 'Substance 2 quantity',
            'single_acute_effect' => 'Substance 2 single acute effect',
            'repeated_low_effect' => 'Substance 2 repeated low effect',
        ]);

        $this->assertDatabaseHas('micro_organisms', [
            'form_id' => $savedForm->id,
            'micro_organism' => 'Micro-organism 1',
            'classification' => 'Micro-organism 1 quantity',
            'risk' => 'ACDP Class 1',
            'single_acute_effect' => 'Micro-organism 1 single acute effect',
            'repeated_low_effect' => 'Micro-organism 1 repeated low effect',
        ]);

        $this->assertDatabaseHas('micro_organisms', [
            'form_id' => $savedForm->id,
            'micro_organism' => 'Micro-organism 2',
            'classification' => 'Micro-organism 2 quantity',
            'risk' => 'ACDP Class 2',
            'single_acute_effect' => 'Micro-organism 2 single acute effect',
            'repeated_low_effect' => 'Micro-organism 2 repeated low effect',
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $savedForm->id,
            'hazard' => 'Risk 1 hazard',
            'consequences' => 'Risk 1 consequences',
            'control_measures' => 'Risk 1 control measures',
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $savedForm->id,
            'hazard' => 'Risk 2 hazard',
            'consequences' => 'Risk 2 consequences',
            'control_measures' => 'Risk 2 control measures',
        ]);
    }

    public function testUserCanEditAndSaveBiologicalForm()
    {
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::create([
            'type' => 'Biological',
            'user_id' => $user->id,
            'multi_user' => false,
            'title' => 'Form title',
            'management_unit' => 'Form unit',
            'review_date' => '2023-01-01',
            'location' => 'Form location',
            'description' => 'Form description',
            'supervisor_id' => $supervisor->id,
        ]);

        $coshhSection = CoshhFormDetails::create([
            'form_id' => $form->id,
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

        $substance1 = Substance::create([
            'form_id' => $form->id,
            'substance' => 'Substance 1',
            'quantity' => 'Substance 1 quantity',
            'single_acute_effect' => 'Substance 1 single acute effect',
            'repeated_low_effect' => 'Substance 1 repeated low effect',
        ]);

        $substance2 = Substance::create([
            'form_id' => $form->id,
            'substance' => 'Substance 2',
            'quantity' => 'Substance 2 quantity',
            'single_acute_effect' => 'Substance 2 single acute effect',
            'repeated_low_effect' => 'Substance 2 repeated low effect',
        ]);

        $microOrganism1 = MicroOrganism::create([
            'form_id' => $form->id,
            'micro_organism' => 'Micro-organism 1',
            'classification' => 'Micro-organism 1 quantity',
            'risk' => 'ACDP Class 1',
            'single_acute_effect' => 'Micro-organism 1 single acute effect',
            'repeated_low_effect' => 'Micro-organism 1 repeated low effect',
        ]);

        $microOrganism2 = MicroOrganism::create([
            'form_id' => $form->id,
            'micro_organism' => 'Micro-organism 2',
            'classification' => 'Micro-organism 2 quantity',
            'risk' => 'ACDP Class 2',
            'single_acute_effect' => 'Micro-organism 2 single acute effect',
            'repeated_low_effect' => 'Micro-organism 2 repeated low effect',
        ]);

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
            ->assertSet('coshhSection.control_measures', 'Form control measures')
            ->assertSet('coshhSection.work_site', 'Form work site')
            ->assertSet('coshhSection.further_risks', 'Form further risks')
            ->assertSet('coshhSection.disposal_methods', 'Form disposal methods')
            ->assertSet('coshhSection.eye_protection', true)
            ->assertSet('coshhSection.face_protection', true)
            ->assertSet('coshhSection.hand_protection', true)
            ->assertSet('coshhSection.foot_protection', true)
            ->assertSet('coshhSection.respiratory_protection', true)
            ->assertSet('coshhSection.other_protection', 'Form other protection')
            ->assertSet('coshhSection.instructions', true)
            ->assertSet('coshhSection.spill_neutralisation', true)
            ->assertSet('coshhSection.eye_irrigation', true)
            ->assertSet('coshhSection.body_shower', true)
            ->assertSet('coshhSection.first_aid', true)
            ->assertSet('coshhSection.breathing_apparatus', true)
            ->assertSet('coshhSection.external_services', true)
            ->assertSet('coshhSection.poison_antidote', true)
            ->assertSet('coshhSection.other_emergency', 'Form other emergency')
            ->assertSet('coshhSection.routine_approval', true)
            ->assertSet('coshhSection.specific_approval', true)
            ->assertSet('coshhSection.personal_supervision', true)

            //Monitoring
            ->assertSet('coshhSection.airborne_monitoring', true)
            ->assertSet('coshhSection.biological_monitoring', true)

            //Informing
            ->assertSet('coshhSection.inform_lab_occupants', true)
            ->assertSet('coshhSection.inform_cleaners', true)
            ->assertSet('coshhSection.inform_contractors', true)
            ->assertSet('coshhSection.inform_other', 'Form inform other')

            ->assertSet('form.supervisor_id', $supervisor->id);

        //Risks - deleting one
        $content->call('deleteRisk', 1);

        //Substances - delete 1
        $content->call('deleteSubstance', 1);

        //Micro-organisms - delete 1
        $content->call('deleteMicroOrganism', 1);

        $content
            ->set('form.title', 'New title')
            ->call('save');

        $this->assertEquals($form->fresh()->risks->count(), 1);
        $this->assertEquals($form->fresh()->substances->count(), 1);
        $this->assertEquals($form->fresh()->microOrganisms->count(), 1);

        $this->assertDatabaseHas('forms', [
            'user_id' => $user->id,
            'type' => 'Biological',
            'multi_user' => false,
            'title' => 'New title',
            'management_unit' => 'Form unit',
            'review_date' => '2023-01-01',
            'location' => 'Form location',
            'description' => 'Form description',
        ]);

        $this->assertDatabaseHas('coshh_form_details', [
            'form_id' => $form->id,
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
        ]);

        $this->assertDatabaseHas('substances', [
            'form_id' => $form->id,
            'substance' => 'Substance 1',
            'quantity' => 'Substance 1 quantity',
            'single_acute_effect' => 'Substance 1 single acute effect',
            'repeated_low_effect' => 'Substance 1 repeated low effect',
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
            'hazard' => 'Risk 1 hazard',
            'consequences' => 'Risk 1 consequences',
            'control_measures' => 'Risk 1 control measures',
        ]);

        $this->assertDatabaseMissing('risks', [
            'form_id' => $form->id,
            'hazard' => 'Risk 2 hazard',
            'consequences' => 'Risk 2 consequences',
            'control_measures' => 'Risk 2 control measures',
        ]);
    }
}
