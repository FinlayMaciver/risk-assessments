<div class="card">
    <div class="card-header fw-bold">Overview</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label for="title" class="form-label">Title of Task/Activity</label>
                <input name="title" type="text" class="form-control @error('form.title') is-invalid @enderror" placeholder="Title" wire:model="form.title">
                @error('form.title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="management_unit" class="form-label">Management Unit</label>
                <input name="management_unit" type="text" class="form-control @error('form.management_unit') is-invalid @enderror" placeholder="Management unit" wire:model="form.management_unit">
                @error('form.management_unit') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="location" class="form-label">Location (Site/Building/Room)</label>
                <input name="location" type="text" class="form-control @error('form.location') is-invalid @enderror" placeholder="Location" wire:model="form.location">
                @error('form.location') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label">Assessment Date</label>
                <input name="date" type="text" class="form-control" value="{{ now()->format('d/m/Y') }}" disabled>
            </div>
            <div class="col-md-6">
                <label for="review_date" class="form-label">Review Date</label>
                <input name="review_date" type="date" class="form-control @error('form.review_date') is-invalid @enderror" placeholder="Review Date" wire:model="form.review_date" min="{{ now()->format('Y-m-d') }}" max="{{ now()->addYear()->format('Y-m-d') }}">
                @error('form.review_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label for="full_name" class="form-label">Assessor's Name</label>
                <input name="full_name" type="text" class="form-control" value="{{ auth()->user()->full_name }}" disabled>
            </div>
            <div class="col-md-6">
                <label for="job_title" class="form-label">Job Title</label>
                <input name="job_title" type="text" class="form-control" value="{{ auth()->user()->job_title }}">
            </div>
            <div class="col-md-12">
                <label for="description" class="form-label">Description of Task</label>
                <textarea name="description" class="form-control @error('form.description') is-invalid @enderror" placeholder="Description" wire:model="form.description"></textarea>
                @error('form.description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-12">
                <label for="type" class="form-label">Form Type</label><br>
                <div class="form-check form-check-inline">
                    <input wire:model="form.type" class="form-check-input" type="radio" name="type" id="general" value="General">
                    <label class="form-check-label" for="general">General</label>
                </div>
                <div class="form-check form-check-inline">
                    <input wire:model="form.type" class="form-check-input" type="radio" name="type" id="chemical" value="Chemical">
                    <label class="form-check-label" for="chemical">Chemical</label>
                </div>
                <div class="form-check form-check-inline">
                    <input wire:model="form.type" class="form-check-input" type="radio" name="type" id="bio" value="Biological">
                    <label class="form-check-label" for="bio">Biological</label>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
