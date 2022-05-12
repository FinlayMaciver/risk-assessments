<?php

namespace Tests\Feature\Forms;

use App\Models\Form;
use App\Models\Risk;
use App\Models\User;
use App\Notifications\FormSubmitted;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class GeneralFormTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    public function testUserCanStartSubmittingANewGeneralForm()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('form.create'));

        $response->assertStatus(200);
        $response->assertSee('Risk Assessment');
        $response->assertSee('Save');
    }

    public function testUserCanSubmitANewGeneralForm()
    {
        Notification::fake();
        Storage::fake('coshh');
        $user = User::factory()->create();
        $supervisor = User::factory()->create();

        $form = new Form([
            'user_id' => $user->id,
            'type' => 'General',
        ]);

        $form->risks = new Collection([
            1 => new Risk([
                'hazard' => 'Risk 1 hazard',
                'consequences' => 'Risk 1 consequences',
                'likelihood_without' => 1,
                'impact_without' => 1,
                'control_measures' => 'Risk 1 control measures',
                'likelihood_with' => 1,
                'impact_with' => 1,
            ]),
            2 => new Risk([
                'hazard' => 'Risk 2 hazard',
                'consequences' => 'Risk 2 consequences',
                'likelihood_without' => 1,
                'impact_without' => 1,
                'control_measures' => 'Risk 2 control measures',
                'likelihood_with' => 1,
                'impact_with' => 1,
            ]),
        ]);

        $file = UploadedFile::fake()->image('test.jpg');

        $content = Livewire::actingAs($user)
        ->test(\App\Http\Livewire\Form\Partials\Content::class, ['form' => $form])
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.type', 'General')
            ->assertSet('form.multi_user', false)
            ->set('form.title', 'Form title')
            ->set('form.management_unit', 'Form unit')
            ->set('form.location', 'Form location')
            ->set('form.review_date', '2023-01-01')
            ->set('form.description', 'Form description')
            ->set('supervisor', $supervisor)
            ->set('form.supervisor_id', $supervisor->id);

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
            'supervisor_id' => $supervisor->id,
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $savedForm->id,
            'hazard' => 'Risk 1 hazard',
            'consequences' => 'Risk 1 consequences',
            'likelihood_without' => 1,
            'impact_without' => 1,
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 1,
            'impact_with' => 1,
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $savedForm->id,
            'hazard' => 'Risk 2 hazard',
            'consequences' => 'Risk 2 consequences',
            'likelihood_without' => 1,
            'impact_without' => 1,
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 1,
            'impact_with' => 1,
        ]);

        $this->assertDatabaseHas('files', [
            'form_id' => $savedForm->id,
            'original_filename' => 'test.jpg',
        ]);

        Storage::disk('coshh')->assertExists('form_1/file_1.dat');
        Notification::assertSentTo($supervisor, FormSubmitted::class);
    }

    public function testUserCanEditAndSaveAGeneralForm()
    {
        Storage::fake('coshh');
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::create([
            'type' => 'General',
            'user_id' => $user->id,
            'multi_user' => false,
            'title' => 'Form title',
            'management_unit' => 'Form unit',
            'review_date' => '2022-01-01',
            'location' => 'Form location',
            'description' => 'Form description',
            'supervisor_id' => $supervisor->id,
        ]);

        $risk1 = Risk::create([
            'form_id' => $form->id,
            'hazard' => 'Risk 1 hazard',
            'consequences' => 'Risk 1 consequences',
            'likelihood_without' => 1,
            'impact_without' => 1,
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 1,
            'impact_with' => 1,
        ]);
        $risk2 = Risk::create([
            'form_id' => $form->id,
            'hazard' => 'Risk 2 hazard',
            'consequences' => 'Risk 2 consequences',
            'likelihood_without' => 1,
            'impact_without' => 1,
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 1,
            'impact_with' => 1,
        ]);

        $file1 = UploadedFile::fake()->image('test1.jpg');
        $file2 = UploadedFile::fake()->image('test2.jpg');

        $form->addFile($file1);
        $form->addFile($file2);

        $content = Livewire::actingAs($user)
        ->test(\App\Http\Livewire\Form\Partials\Content::class, ['form' => $form])
            ->assertSet('form.user_id', $user->id)
            ->assertSet('form.type', 'General')
            ->assertSet('form.multi_user', false)
            ->assertSet('form.title', 'Form title')
            ->assertSet('form.location', 'Form location')
            ->assertSet('form.description', 'Form description')
            ->assertSet('form.supervisor_id', $supervisor->id);

        //Risks - deleting one
        $content->call('deleteRisk', 1);

        //Files - deleting one
        $files = $form->fresh()->files;
        $content->set('files', $files->forget(1));

        $content->set('form.title', 'New title')
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
            'supervisor_id' => null,
        ]);

        $this->assertDatabaseHas('risks', [
            'form_id' => $form->id,
            'hazard' => 'Risk 1 hazard',
            'consequences' => 'Risk 1 consequences',
            'likelihood_without' => 1,
            'impact_without' => 1,
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 1,
            'impact_with' => 1,
        ]);

        $this->assertDatabaseMissing('risks', [
            'form_id' => $form->id,
            'hazard' => 'Risk 2 hazard',
            'consequences' => 'Risk 2 consequences',
            'likelihood_without' => 1,
            'impact_without' => 1,
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 1,
            'impact_with' => 1,
        ]);

        $this->assertDatabaseHas('files', [
            'form_id' => $form->id,
            'original_filename' => 'test1.jpg',
        ]);

        $this->assertDatabaseMissing('files', [
            'form_id' => $form->id,
            'original_filename' => 'test2.jpg',
        ]);

        Storage::disk('coshh')->assertExists('form_1/file_1.dat');
        Storage::disk('coshh')->assertMissing('form_1/file_2.dat');
    }

    /** @test */
    public function testUserCanViewAGeneralForm()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::create([
            'type' => 'General',
            'user_id' => $user->id,
            'multi_user' => false,
            'title' => 'Form title',
            'location' => 'Form location',
            'management_unit' => 'Form unit',
            'review_date' => '2022-01-01',
            'description' => 'Form description',
            'supervisor_id' => $supervisor->id,
        ]);

        $risk1 = Risk::create([
            'form_id' => $form->id,
            'hazard' => 'Risk 1 hazard',
            'consequences' => 'Risk 1 consequences',
            'likelihood_without' => 1,
            'impact_without' => 1,
            'control_measures' => 'Risk 1 control measures',
            'likelihood_with' => 1,
            'impact_with' => 1,
        ]);
        $risk2 = Risk::create([
            'form_id' => $form->id,
            'hazard' => 'Risk 2 hazard',
            'consequences' => 'Risk 2 consequences',
            'likelihood_without' => 1,
            'impact_without' => 1,
            'control_measures' => 'Risk 2 control measures',
            'likelihood_with' => 1,
            'impact_with' => 1,
        ]);

        $response = $this->actingAs($user)->get(route('form.show', $form->id));

        $response->assertStatus(200);
        $response->assertSee($user->full_name);
        $response->assertSee($supervisor->full_name);
        $response->assertSee('Form title');
        $response->assertSee('Form location');
        $response->assertSee('Form description');

        // TODO: Add more assertions
        // $response->assertSee('Risk 1 risk');
        // $response->assertSee('Risk 1 severity');
        // $response->assertSee('Risk 1 control measures');
        // $response->assertSee('Risk 1 likelihood with');
        // $response->assertSee('Risk 1 likelihood without');
        // $response->assertSee('Risk 2 risk');
        // $response->assertSee('Risk 2 severity');
        // $response->assertSee('Risk 2 control measures');
        // $response->assertSee('Risk 2 likelihood with');
        // $response->assertSee('Risk 2 likelihood without');

        $response->assertDontSee('Hazardous substances involved');
        $response->assertDontSee('Hazards of micro-organisms involved');
    }
}
