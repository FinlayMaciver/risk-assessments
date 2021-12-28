@component('mail::message')
Dear {{ $form->user->forenames }},

This is an automated message to let you know your Risk Assessment form has been rejected by the {{ $rejectedBy }}.

@if ($form->supervisor_comments)
    {{ $form->supervisor_comments }}
@endif

@if ($form->supervisor_comments)
    {{ $form->lab_guardian_comments }}
@endif

@if ($form->supervisor_comments)
    {{ $form->coshh_admin_comments }}
@endif

@component('mail::button', ['url' => route('form.show', $form->id)])
View Form
@endcomponent

Kind regards,<br>
School of Engineering - COSHH Risk Assessment
@endcomponent
