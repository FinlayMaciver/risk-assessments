@if ($formsAwaitingApproval->count())
<div class="alert alert-info mb-3" role="alert">
    There are forms awaiting your approval.<hr>
    @foreach($formsAwaitingApproval as $form)
        @if (!($form->supervisor_id == auth()->user()->id && $form->awaitingReviewerApproval()))
            <a href="{{ route('form.show', $form->id) }}">{{ $form->title }}</a> - {{ $form->user->full_name }}<br>
        @endif
    @endforeach
</div>
@endif
