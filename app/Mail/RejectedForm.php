<?php

namespace App\Mail;

use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class RejectedForm extends Mailable
{
    use Queueable, SerializesModels;

    public $form;

    public $rejectedBy;

    public function __construct(Form $form, $rejectedBy)
    {
        $this->form = $form;
        $this->rejectedBy = $rejectedBy;
    }

    public function build()
    {
        return $this
            ->subject('COSHH Risk Assessment - Form Rejected By '.Str::title($this->rejectedBy))
            ->markdown('emails.form.rejected', [
                'rejectedBy' => $this->rejectedBy,
                'form' => $this->form,
            ]);
    }
}
