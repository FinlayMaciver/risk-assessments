<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ApprovalTest extends TestCase
{
    /** @test */
    public function testReviewerIsNotifiedOnHomePageAboutAwaitingApprovals()
    {
        $this->withoutExceptionHandling();
        Notification::fake();
        $user = User::factory()->create();
        $reviewer1 = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
        ]);
        $form->reviewers()->attach($reviewer1);

        $response = $this->actingAs($reviewer1)->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee("My Forms");
        $response->assertSee($form->title);
    }

    /** @test */
    public function testSupervisorCantSeeAwaitingApprovalsUntilReviewersHaveApproved()
    {
        $this->withoutExceptionHandling();
        Notification::fake();
        $user = User::factory()->create();
        $reviewer1 = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
        ]);
        $form->reviewers()->attach($reviewer1);

        $response = $this->actingAs($supervisor)->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee("My Forms");
        $response->assertDontSee($form->title);

        $form->reviewerApproval($reviewer1, true);

        $response = $this->actingAs($supervisor)->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee("My Forms");
        $response->assertSee($form->title);
    }
}
