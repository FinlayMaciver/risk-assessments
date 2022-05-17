<div class="col-md-8">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                    <div class="g-0 mb-1">
                        <i class="fa-solid fa-t me-2"></i>
                        <span class="d-none d-xl-inline-block">Title</span>
                    </div>
                    <div class="g-0 mb-1">
                        <i class="fa-solid fa-building me-2"></i>
                        <span class="d-none d-xl-inline-block">Management Unit</span>
                    </div>
                    <div class="g-0 mb-1">
                        <i class="fa-solid fa-tag me-2"></i>
                        <span class="d-none d-xl-inline-block">Hazard Type</span>
                    </div>
                    <div class="g-0 mb-1">
                        <i class="fa-solid fa-location-arrow me-2"></i>
                        <span class="d-none d-xl-inline-block">Location</span>

                    </div>
                    <div class="g-0 mb-1">
                        <i class="fa-solid fa-calendar-alt me-2"></i>
                        <span class="d-none d-xl-inline-block">Review Date</span>
                    </div>
                    <div class="g-0 mb-1">
                        <i class="fa-solid fa-spinner me-2"></i>
                        <span class="d-none d-xl-inline-block">Status</span>
                    </div>
                    <div class="g-0 mb-1">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        <span class="d-none d-xl-inline-block">Description</span>
                    </div>
                </div>
                <div class="col">
                    <div class="g-0 mb-1">
                        <span>{{ $form->title }}</span>
                    </div>
                    <div class="g-0 mb-1">
                        <span>{{ $form->management_unit }}</span>
                    </div>
                    <div class="g-0 mb-1">
                        <span>{{ $form->type }}</span>
                    </div>
                    <div class="g-0 mb-1">
                        <span>{{ $form->location }}</span>
                    </div>
                    <div class="g-0 mb-1">
                        <span>{{ $form->formatted_review_date }}</span>
                    </div>
                    <div class="g-0 mb-1">
                        <span class="@if ($form->status == 'Rejected') text-danger @elseif ($form->status == 'Approved') text-success @else text-info @endif">{{ $form->status }}</span>
                    </div>
                    <div class="g-0 mb-1">
                        <span>{{ $form->description }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
