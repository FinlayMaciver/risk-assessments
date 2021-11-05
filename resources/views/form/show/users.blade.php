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
            </div>
            @endif
            @if($form->labGuardian)
            <div class="g-0">
                <i class="me-2 fas fa-user-cog"></i>
                <span class="d-none d-xl-inline-block">Lab guardian - </span>
                <span>{{ $form->labGuardian->full_name }}</span>
            </div>
            @endif
        </div>
    </div>
</div>
