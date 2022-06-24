<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\User;
use App\Notifications\ApprovedForm;
use App\Notifications\FormSubmitted;
use App\Notifications\RejectedForm;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ApprovalTest extends TestCase
{
    public function testSupervisorCanApproveForm()
    {
        Notification::fake();
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $form->supervisorApproval(true);

        $this->assertTrue($form->supervisor_approval);
        Notification::assertSentTo($user, ApprovedForm::class);
    }

    public function testSupervisorCanDenyFormWithComments()
    {
        Notification::fake();
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $comment = 'Form not filled correctly';
        $form->supervisorApproval(false, $comment);

        $this->assertFalse($form->supervisor_approval);
        $this->assertEquals($form->supervisor_comments, $comment);
        Notification::assertSentTo($user, RejectedForm::class);
    }

    public function testReviewerCanApproveForm()
    {
        Notification::fake();
        $user = User::factory()->create();
        $reviewer = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
        ]);
        $form->reviewers()->attach($reviewer);

        $form->reviewerApproval($reviewer, true);

        $this->assertTrue($form->reviewers[0]->pivot->approved);
        Notification::assertSentTo($user, ApprovedForm::class);
    }

    public function testReviewerCanDenyFormWithComments()
    {
        Notification::fake();
        $user = User::factory()->create();
        $reviewer = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
        ]);

        $form->reviewers()->attach($reviewer);

        $comment = 'Form not filled correctly';
        $form->reviewerApproval($reviewer, false, $comment);

        $this->assertFalse($form->reviewers[0]->pivot->approved);
        $this->assertEquals($form->reviewers[0]->pivot->comments, $comment);
        Notification::assertSentTo($user, RejectedForm::class);
    }

    /** @test */
    public function testReviewerAndSupervisorApprove()
    {
        Notification::fake();
        $user = User::factory()->create();
        $reviewer1 = User::factory()->create();
        $reviewer2 = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
        ]);
        $form->reviewers()->attach($reviewer1);
        $form->reviewers()->attach($reviewer2);

        $form->reviewerApproval($reviewer1, true);

        $this->assertTrue($form->reviewers[0]->pivot->approved);
        $this->assertEquals($form->status, 'Pending');
        Notification::assertNotSentTo($supervisor, FormSubmitted::class);
        Notification::assertSentTo($user, ApprovedForm::class);

        $form->reviewerApproval($reviewer2, true);
        $this->assertTrue($form->fresh()->reviewers[1]->pivot->approved);
        $this->assertEquals($form->status, 'Pending');
        Notification::assertSentTo($user, ApprovedForm::class);
        Notification::assertSentTo($supervisor, FormSubmitted::class);

        $form->supervisorApproval(true);

        $this->assertTrue($form->supervisor_approval);
        $this->assertEquals('Approved', $form->status);
        Notification::assertSentTo($user, ApprovedForm::class);
    }

    /** @test */
    public function testReviewerRejectsAndSupervisorIsntNotified()
    {
        $this->withoutExceptionHandling();
        Notification::fake();
        $user = User::factory()->create();
        $reviewer1 = User::factory()->create();
        $reviewer2 = User::factory()->create();
        $supervisor = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
        ]);
        $form->reviewers()->attach($reviewer1);
        $form->reviewers()->attach($reviewer2);

        $form->reviewerApproval($reviewer1, true);

        $this->assertTrue($form->fresh()->reviewers[0]->pivot->approved);
        $this->assertEquals($form->fresh()->status, 'Pending');
        Notification::assertNotSentTo($supervisor, FormSubmitted::class);
        Notification::assertSentTo($user, ApprovedForm::class);

        $form->reviewerApproval($reviewer2, false, 'Boo');
        $this->assertFalse($form->fresh()->reviewers[1]->pivot->approved);
        $this->assertEquals($form->fresh()->status, 'Rejected');
        Notification::assertSentTo($user, RejectedForm::class);
        Notification::assertNotSentTo($supervisor, FormSubmitted::class);
    }

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
