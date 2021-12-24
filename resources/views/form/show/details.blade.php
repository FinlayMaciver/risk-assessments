<div class="col-md-8">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                    <div class="g-0 mb-1">
                        <i class="fas fa-tag me-2"></i>
                        <span class="d-none d-xl-inline-block">Form type</span>
                    </div>
                    <div class="g-0 mb-1">
                        <i class="fas fa-spinner me-2"></i>
                        <span class="d-none d-xl-inline-block">Status</span>
                    </div>
                    <div class="g-0 mb-1">
                        <i class="fas fa-location-arrow me-2"></i>
                        <span class="d-none d-xl-inline-block">Location</span>

                    </div>
                    <div class="g-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <span class="d-none d-xl-inline-block">Description</span>
                    </div>
                </div>
                <div class="col">
                    <div class="g-0 mb-1">
                        <span>{{ $form->type }}</span>
                    </div>
                    <div class="g-0 mb-1">
                        <span class="@if ($form->status == 'Denied') text-danger @elseif ($form->status == 'Approved') text-success @else text-info @endif">{{ $form->status }}</span>
                    </div>
                    <div class="g-0 mb-1">
                        <span>{{ $form->location }}</span>
                    </div>
                    <div class="g-0 mb-1">
                        <span>{{ $form->description }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
