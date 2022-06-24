<?php

namespace App\Notifications;

use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class RejectedForm extends Notification
{
    use Queueable;

    public Form $form;

    public $rejectedBy;

    public function __construct(Form $form, $rejectedBy)
    {
        $this->form = $form;
        $this->rejectedBy = $rejectedBy;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('COSHH Risk Assessment - Form Rejected By '.Str::title($this->rejectedBy))
            ->markdown('emails.form.rejected', [
                'rejectedBy' => $this->rejectedBy,
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
