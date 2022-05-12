<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\User;
use Tests\TestCase;

class HomeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    public function testHomePageShowsOnlyLoggedInUsersForms()
    {
        $user = User::factory()->create();
        $forms = Form::factory()->count(2)->create(['user_id' => $user->id]);
        $forms2 = Form::factory()->count(2)->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee($forms[0]->title);
        $response->assertSee($forms[1]->title);
        $response->assertDontSee($forms2[0]->title);
        $response->assertDontSee($forms2[1]->title);
    }

    public function testUserHasNoFormsSoSeesNoForms()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('No forms to show.');
    }

    public function testApprovedFormsPageShowsApprovedFormsByUser()
    {
        $user = User::factory()->create();
        $personalForms = Form::factory()->count(2)->create(['user_id' => $user->id]);
        $supervisingForms = Form::factory()->count(2)->create(['supervisor_id' => $user->id]);
        $reviewerForms = Form::factory()->count(2)->create();
        $reviewerForms[0]->reviewers()->attach($user, ['approved' => true]);
        $reviewerForms[1]->reviewers()->attach($user, ['approved' => null]);
        $signedForm = Form::factory()->create();
        $signedForm->users()->attach($user);

        $response = $this->actingAs($user)->get(route('approved-forms'));

        $response->assertStatus(200);
        $response->assertDontSee($personalForms[0]->title);
        $response->assertDontSee($personalForms[1]->title);
        $response->assertSee($supervisingForms[0]->title);
        $response->assertSee($supervisingForms[1]->title);
        $response->assertSee($reviewerForms[0]->title);
        $response->assertSee($reviewerForms[1]->title);
        $response->assertDontSee($signedForm->title);
    }

    public function testSignedFormsPageShowsSignedFormsByUser()
    {
        $user = User::factory()->create();
        $personalForms = Form::factory()->count(2)->create(['user_id' => $user->id]);
        $supervisingForms = Form::factory()->count(2)->create(['supervisor_id' => $user->id]);
        $reviewerForms = Form::factory()->count(2)->create();
        $reviewerForms[0]->reviewers()->attach($user, ['approved' => true]);
        $reviewerForms[1]->reviewers()->attach($user, ['approved' => null]);
        $signedForm = Form::factory()->create();
        $signedForm->users()->attach($user);

        $response = $this->actingAs($user)->get(route('signed-forms'));

        $response->assertStatus(200);
        $response->assertDontSee($personalForms[0]->title);
        $response->assertDontSee($personalForms[1]->title);
        $response->assertDontSee($supervisingForms[0]->title);
        $response->assertDontSee($supervisingForms[1]->title);
        $response->assertDontSee($reviewerForms[0]->title);
        $response->assertDontSee($reviewerForms[1]->title);
        $response->assertSee($signedForm->title);
    }

    public function testAllFormsPageShowsAllForms()
    {
        $user = User::factory()->create();
        $personalForms = Form::factory()->count(2)->create(['user_id' => $user->id]);
        $supervisingForms = Form::factory()->count(2)->create(['supervisor_id' => $user->id]);
        $reviewerForms = Form::factory()->count(2)->create();
        $reviewerForms[0]->reviewers()->attach($user, ['approved' => true]);
        $reviewerForms[1]->reviewers()->attach($user, ['approved' => null]);
        $signedForm = Form::factory()->create();
        $signedForm->users()->attach($user);

        $response = $this->actingAs($user)->get(route('all-forms'));

        $response->assertStatus(200);
        $response->assertSee($personalForms[0]->title);
        $response->assertSee($personalForms[1]->title);
        $response->assertSee($supervisingForms[0]->title);
        $response->assertSee($supervisingForms[1]->title);
        $response->assertSee($reviewerForms[0]->title);
        $response->assertSee($reviewerForms[1]->title);
        $response->assertSee($signedForm->title);
    }
}
