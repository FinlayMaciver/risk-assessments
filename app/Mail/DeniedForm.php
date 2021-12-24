<?php

namespace App\Mail;

use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class DeniedForm extends Mailable
{
    use Queueable, SerializesModels;

    public $form;
    public $deniedBy;

    public function __construct(Form $form, $deniedBy)
    {
        $this->form = $form;
        $this->deniedBy = $deniedBy;
    }

    public function build()
    {
        return $this
            ->subject('COSHH Risk Assessment - Form Rejected By ' . Str::title($this->deniedBy))
            ->markdown('emails.form.denied', [
                'deniedBy' => $this->deniedBy,
                'form' => $this->form,
            ]);
    }
}
