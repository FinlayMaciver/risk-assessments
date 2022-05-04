<?php

namespace App\Notifications;

use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ApprovedForm extends Notification
{
    use Queueable;

    public Form $form;

    public $approvedBy;

    public function __construct(Form $form, $approvedBy)
    {
        $this->form = $form;
        $this->approvedBy = $approvedBy;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('COSHH Risk Assessment - Form Approved By '.Str::title($this->approvedBy))
            ->markdown('emails.form.approved', [
                'approvedBy' => $this->approvedBy,
                'form' => $this->form,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
