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

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee($forms[0]->title);
        $response->assertSee($forms[1]->title);
    }

    public function testUserHasNoFormsSoSeesNoForms()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('No forms to show.');
    }
}
