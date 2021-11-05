<div class="card">
    <div class="card-header fw-bold">Informing Others</div>
    <div class="card-body">
        <h6 class="card-title">Other persons who need to be told in full or in part about the information in this risk assessment:</h6>
        <div class="form-check form-switch">
            <input name="inform_lab_occupants" wire:model="form.inform_lab_occupants" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="inform_lab_occupants">Academic/Postgraduate staff, research & undergraduate students and technicians working in the lab</label>
        </div>
        <div class="form-check form-switch">
            <input name="inform_cleaners" wire:model="form.inform_cleaners" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="inform_cleaners">Cleaners</label>
        </div>
        <div class="form-check form-switch">
            <input name="inform_contractors" wire:model="form.inform_contractors" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="inform_contractors">Contractors</label>
        </div>
        <div class="input-group input-group-sm flex-nowrap">
            <span class="input-group-text" id="addon-wrapping">Other</span>
            <input name="inform_other" wire:model="form.inform_other" type="text" class="form-control" placeholder="Other">
        </div>
    </div>
</div>
<br>
