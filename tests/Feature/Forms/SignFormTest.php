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

        $this->assertEquals($form->users()->count(), 0);

        $form->signForm($user);

        $this->assertEquals($form->users()->count(), 1);
    }
}
