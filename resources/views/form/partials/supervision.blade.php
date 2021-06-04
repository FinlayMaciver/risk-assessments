<div class="card">
    <div class="card-header fw-bold">Supervision required</div>
    <div class="card-body">
        <div class="form-check form-switch">
            <input name="routine_approval" wire:model="form.routine_approval" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="routine_approval">Supervisor approves straightforward and routine work</label>
        </div>
        <div class="form-check form-switch">
            <input name="specific_approval" wire:model="form.specific_approval" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="specific_approval">Supervisor will specifically approve the scheme of work outlined above</label>
        </div>
        <div class="form-check form-switch">
            <input name="personal_supervision" wire:model="form.personal_supervision" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="personal_supervision">Supervisor will provide personal supervision to control and oversee the work</label>
        </div>
    </div>
</div>
<br>
