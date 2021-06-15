<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\User;
use Tests\TestCase;

class HomeTest extends TestCase
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
}
