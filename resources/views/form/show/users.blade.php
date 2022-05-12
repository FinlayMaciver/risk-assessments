<div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="g-0 mb-1">
                <i class="me-2 fas fa-user d-inline-block"></i>
                <span class="d-none d-xl-inline-block">Submitted by - </span>
                <span>{{ $form->user->full_name }}</span>
            </div>

            @if($form->supervisor)
                <hr>
                <div class="g-0 mb-1">
                    <i class="me-2 fas fa-user-shield"></i>
                    <span class="d-none d-xl-inline-block">Supervisor - </span>
                    <span>{{ $form->supervisor->full_name }}</span>
                    @if ($form->supervisor_approval)
                        <span class="float-end text-success">Approved</span>
                    @elseif ($form->supervisor_approval === false)
                        <span class="float-end text-danger">Rejected</span>
                    @endif
                </div>
            @endif

            @if($form->has_comments)
                <hr>
                <div class="g-0">
                    @if($form->supervisor_comments)
                        <p>
                            <b>Supervisor Comments:</b><br>
                            {{ $form->supervisor_comments }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
