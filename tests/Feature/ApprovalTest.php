<?php

namespace Tests\Feature;

use App\Mail\RejectedForm;
use App\Models\Form;
use App\Models\User;
use App\Notifications\ApprovedForm;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ApprovalTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

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
        Mail::fake();
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
        Mail::assertSent(RejectedForm::class, function ($mail) use ($user, $form) {
            return $mail->hasTo($user->email);
        });
    }
}
