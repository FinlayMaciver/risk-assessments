<?php

namespace App\Notifications;

use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FormSubmitted extends Notification
{
    use Queueable;

    public $form;

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('COSHH Risk Assessment - Form Approval Required')
            ->markdown('emails.form.submitted', [
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
