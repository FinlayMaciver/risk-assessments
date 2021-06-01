<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <label for="control_measures" class="form-label">
                Specific control measures required for this task and not covered in the laboratory's General Code of Practice
            </label>
            <textarea name="control_measures" class="form-control" wire:model="form.control_measures"></textarea>
        </div>
        @if ($form->type == 'General')
            <div class="mb-3">
                <label for="chemicals_involved" class="form-label">
                    (Bio)Chemicals or micro-organisms involved (hazardous or otherwise)
                </label>
                <textarea name="chemicals_involved" class="form-control" wire:model="form.chemicals_involved"></textarea>
            </div>
        @endif
        <div class="mb-3">
            <label for="work_site" class="form-label">
                Should the work be carried out on the open bench, using other local exhaust ventilation, in a fume cupboard or in a glove box?
            </label>
            <textarea name="control_measures" class="form-control" wire:model="form.work_site"></textarea>
        </div>
        <div class="mb-3">
            <label for="disposal_methods" class="form-label">
                Disposal methods for materials used and wastes produced (if any)
            </label>
            <textarea name="disposal_methods" class="form-control" wire:model="form.disposal_methods"></textarea>
        </div>
        <div class="mb-3">
            <label for="further_risks" class="form-label">
                Further information not already covered<br>
                <small>e.g. additional risks, additional hazardous substances and, when significant risks/hazards are present, a detailed scheme of work (if not given above)</small>
            </label>
            <textarea name="further_risks" class="form-control" wire:model="form.further_risks"></textarea>
        </div>
    </div>
</div>
<br>
