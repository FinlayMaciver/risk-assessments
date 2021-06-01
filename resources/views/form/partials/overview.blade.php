<div class="card">
    <div class="card-header fw-bold">Overview</div>
    <div class="card-body">
        <div class="mb-3">
            <label for="title" class="form-label">Title of task/activity</label>
            <input name="title" type="text" class="form-control" placeholder="Title" wire:model="form.title">
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location(s) where work will be carried out</label>
            <input name="location" type="text" class="form-control" placeholder="Location" wire:model="form.location">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Short description of procedures involved in the activity<br>(where appropriate, detailed protocols can be uploaded at the end of this form)</label>
            <textarea name="description" class="form-control" placeholder="Description" wire:model="form.description"></textarea>
        </div>
    </div>
</div>
<br>
