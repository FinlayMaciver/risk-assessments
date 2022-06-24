<div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <p>
                <i class="fa-solid fa-user"></i>
                <span class="fw-bold">Submitted by:</span><br>
                {{ $form->user->full_name }}
            </p>

            @if($form->supervisor)
                <hr>
                <p>
                    <i class="fa-solid fa-user-shield"></i>
                    <span class="fw-bold">Supervisor:</span><br>
                    {{ $form->supervisor->full_name }}
                    @if ($form->supervisor_approval)
                        <span class="float-end text-success">Approved</span>
                    @elseif ($form->supervisor_approval === false)
                        <span class="float-end text-danger">Rejected</span>
                    @endif
                    @if($form->supervisor_comments)
                        <br><i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i> "{{ $form->supervisor_comments }}"
                    @endif
                </p>
            @endif

            @if($form->reviewers)
                <hr>
                <p>
                    <i class="fa-solid fa-user-pen"></i>
                    <span class="fw-bold">Reviewers:</span>
                    @if($form->reviewers->count())
                        @foreach($form->reviewers as $reviewer)
                            <br>{{ $reviewer->full_name }}
                            @if ($reviewer->pivot->approved)
                                <span class="float-end text-success">Approved</span>
                            @elseif ($reviewer->pivot->approved === false)
                                <span class="float-end text-danger">Rejected</span>
                            @endif
                            @if($reviewer->pivot->comments)
                                <br><i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i> "{{ $reviewer->pivot->comments }}"
                            @endif
                        @endforeach
                    @else
                        <br><span class="fst-italic text-muted">No reviewers</span>
                    @endif
                </p>
            @endif
        </div>
    </div>
</div>
