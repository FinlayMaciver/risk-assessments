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
                        <span class="float-end text-danger">Denied</span>
                    @endif
                </div>
            @endif

            @if($form->labGuardian)
                <div class="g-0">
                    <i class="me-2 fas fa-user-cog"></i>
                    <span class="d-none d-xl-inline-block">Lab guardian - </span>
                    <span>{{ $form->labGuardian->full_name }}</span>
                    @if ($form->lab_guardian_approval)
                        <span class="float-end text-success">Approved</span>
                    @elseif ($form->lab_guardian_approval === false)
                        <span class="float-end text-danger">Denied</span>
                    @endif
                </div>
            @endif

            @if (isset($form->coshh_admin_approval))
                <div class="g-0 mt-1">
                    <i class="me-2 fas fa-user-lock"></i>
                    <span class="d-none d-xl-inline-block">COSHH Admin - </span>
                    <span>{{ \App\Models\User::coshhAdmin()->first()->full_name }}</span>
                    @if ($form->coshh_admin_approval)
                        <span class="float-end text-success">Approved</span>
                    @else
                        <span class="float-end text-danger">Denied</span>
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
                    @if($form->lab_guardian_comments)
                        <p>
                            <b>Lab Guardian Comments:</b><br>
                            {{ $form->lab_guardian_comments }}
                        </p>
                    @endif
                    @if($form->coshh_admin_comments)
                        <p>
                            <b>COSHH Admin Comments:</b><br>
                            {{ $form->coshh_admin_comments }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
