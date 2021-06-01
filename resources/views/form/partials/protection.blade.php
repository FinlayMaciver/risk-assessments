<div class="card">
    <div class="card-header fw-bold">Protection</div>
    <div class="card-body">
        <h6 class="card-title">Personal protective equipment required for some or all aspects of the task:</h6>
        <div class="form-check form-switch">
            <input name="eye_protection" wire.model="form.eye_protection" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="eye_protection">Eye protection</label>
        </div>
        <div class="form-check form-switch">
            <input name="face_protection" wire.model="form.face_protection" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="face_protection">Face protection</label>
        </div>
        <div class="form-check form-switch">
            <input name="hand_protection" wire.model="form.hand_protection" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="hand_protection">Hand protection</label>
        </div>
        <div class="form-check form-switch">
            <input name="foot_protection" wire.model="form.foot_protection" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="foot_protection">Foot protection</label>
        </div>
        <div class="form-check form-switch">
            <input name="respiratory_protection" wire.model="form.respiratory_protection" class="form-check-input" type="checkbox">
            <label class="form-check-label" for="respiratory_protection">Respiratory protection</label>
        </div>
        <div class="input-group input-group-sm flex-nowrap">
            <span class="input-group-text" id="addon-wrapping">Other</span>
            <input name="other_protection" wire:model="form.other_protection" type="text" class="form-control" placeholder="Other protection">
        </div>
    </div>
</div>
<br>
