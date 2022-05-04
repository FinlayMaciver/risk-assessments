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
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    public function testSupervisorCanApproveForm()
    {
        Notification::fake();
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $form->supervisorApproval(true);

        $this->assertTrue($form->supervisor_approval);
        $this->assertNull($form->lab_guardian_approval);
        $this->assertNull($form->coshh_admin_approval);
        Notification::assertSentTo($user, ApprovedForm::class);
    }

    public function testLabGuardianCanApproveForm()
    {
        Notification::fake();
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $form->labGuardianApproval(true);

        $this->assertTrue($form->lab_guardian_approval);
        $this->assertNull($form->supervisor_approval);
        $this->assertNull($form->coshh_admin_approval);
        Notification::assertSentTo($user, ApprovedForm::class);
    }

    public function testCoshhAdminCanApproveForm()
    {
        Notification::fake();
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $form->coshhAdminApproval(true);

        $this->assertNull($form->supervisor_approval);
        $this->assertNull($form->lab_guardian_approval);
        $this->assertTrue($form->coshh_admin_approval);
        $this->assertEquals($form->status, 'Approved');
        Notification::assertSentTo($user, ApprovedForm::class);
    }

    public function testSupervisorCanDenyFormWithComments()
    {
        Mail::fake();
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $coshhAdmin = User::factory()->coshhAdmin()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $comment = 'Form not filled correctly';
        $form->supervisorApproval(false, $comment);

        $this->assertFalse($form->supervisor_approval);
        $this->assertEquals($form->supervisor_comments, $comment);
        $this->assertNull($form->lab_guardian_approval);
        $this->assertNull($form->coshh_admin_approval);
        Mail::assertSent(RejectedForm::class, function ($mail) use ($user, $form, $coshhAdmin) {
            return $mail->hasTo($user->email) &&
                   $mail->hasBcc($form->labGuardian) &&
                   $mail->hasBcc($coshhAdmin);
        });
    }

    public function testLabGuardianCanDenyFormWithComments()
    {
        Mail::fake();
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $coshhAdmin = User::factory()->coshhAdmin()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $comment = 'Form not filled correctly';
        $form->labGuardianApproval(false, $comment);

        $this->assertFalse($form->lab_guardian_approval);
        $this->assertEquals($form->lab_guardian_comments, $comment);
        $this->assertNull($form->supervisor_approval);
        $this->assertNull($form->coshh_admin_approval);
        Mail::assertSent(RejectedForm::class, function ($mail) use ($user, $form, $coshhAdmin) {
            return $mail->hasTo($user->email) &&
                   $mail->hasBcc($form->supervisor) &&
                   $mail->hasBcc($coshhAdmin);
        });
    }

    public function testCoshhAdminCanDenyFormWithComments()
    {
        Mail::fake();
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $labGuardian = User::factory()->create();
        $coshhAdmin = User::factory()->coshhAdmin()->create();
        $form = Form::factory()->create([
            'user_id' => $user->id,
            'supervisor_id' => $supervisor->id,
            'lab_guardian_id' => $labGuardian->id,
        ]);

        $comment = 'Form not filled correctly';
        $form->coshhAdminApproval(false, $comment);

        $this->assertNull($form->supervisor_approval);
        $this->assertNull($form->lab_guardian_approval);
        $this->assertEquals($form->coshh_admin_comments, $comment);
        $this->assertFalse($form->coshh_admin_approval);
        Mail::assertSent(RejectedForm::class, function ($mail) use ($user, $form, $coshhAdmin) {
            return $mail->hasTo($user->email) &&
                $mail->hasBcc($form->supervisor) &&
                $mail->hasBcc($form->labGuardian) &&
                $mail->hasBcc($coshhAdmin);
        });
    }
}
