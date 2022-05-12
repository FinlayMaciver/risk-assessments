<?php

namespace Tests\Feature\Form;

use App\Models\Form;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SignFormTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /** @test */
    public function test_user_can_sign_a_multi_user_form()
    {
        Notification::fake();
        $user = User::factory()->create();
        $form = Form::factory()->approved()->create();

        $this->assertFalse($form->users->contains($user->id));

        $form->signForm($user);

        $this->assertTrue($form->users()->find($user->id)->pivot->signed);
        $this->assertNotNull($form->users()->find($user->id)->pivot->signed_at);
    }

    /** @test */
    public function test_user_can_sign_a_multi_user_form_that_they_are_already_added_to()
    {
        Notification::fake();
        $user = User::factory()->create();
        $form = Form::factory()->approved()->create();
        $form->users()->attach($user);

        $this->assertFalse($form->users()->find($user->id)->pivot->signed);
        $this->assertNull($form->users()->find($user->id)->pivot->signed_at);

        $form->signForm($user);

        $this->assertTrue($form->users()->find($user->id)->pivot->signed);
        $this->assertNotNull($form->users()->find($user->id)->pivot->signed_at);
    }
}
