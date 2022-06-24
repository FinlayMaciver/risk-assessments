<div class="card">
    <div class="card-header fw-bold">Emergency requirements</div>
    <div class="card-body">
        <h6 class="card-title">The following may be required in an emergency:</h6>
        <div class="form-check form-switch">
            <input name="spill_neutralisation" wire:model="coshhSection.spill_neutralisation" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="spill_neutralisation">Spill neutralisation chemicals</label>
        </div>
        <div class="form-check form-switch">
            <input name="eye_irrigation" wire:model="coshhSection.eye_irrigation" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="eye_irrigation">Eye irrigation point</label>
        </div>
        <div class="form-check form-switch">
            <input name="body_shower" wire:model="coshhSection.body_shower" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="body_shower">Body shower</label>
        </div>
        <div class="form-check form-switch">
            <input name="first_aid" wire:model="coshhSection.first_aid" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="first_aid">Other first aid provisions</label>
        </div>
        <div class="form-check form-switch">
            <input name="breathing_apparatus" wire:model="coshhSection.breathing_apparatus" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="breathing_apparatus">Breathing apparatus (with trained operator)</label>
        </div>
        <div class="form-check form-switch">
            <input name="external_services" wire:model="coshhSection.external_services" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="external_services">External emergency services</label>
        </div>
        <div class="form-check form-switch">
            <input name="poison_antidote" wire:model="coshhSection.poison_antidote" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="poison_antidote">Poison antidote</label>
        </div>
        <div class="input-group input-group-sm flex-nowrap">
            <span class="input-group-text" id="addon-wrapping">Other</span>
            <input name="other_emergency" wire:model="coshhSection.other_emergency" type="text" class="form-control" placeholder="Other">
        </div>
    </div>
</div>
<br>
