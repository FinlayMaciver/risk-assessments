@component('mail::message')

This is an automated message to let you know a new Risk Assessment form has been submitted and your approval is required.

@component('mail::button', ['url' => route('form.show', $form->id)])
View Form
@endcomponent

@endcomponent
