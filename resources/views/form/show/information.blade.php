<div class="col-md-6">
    <div class="card">
        <div class="card-header text-center fw-bold">Additional information</div>
        <div class="card-body">
            <p>
                <span class="fw-bold">Specific control measures required for this task and not covered in the laboratory's General Code of Practice:</span><br>
                {{ $form->coshhSection->control_measures ?: 'N/A' }}
            </p>
            @if ($form->type == 'General')
                <p>
                    <span class="fw-bold">(Bio)Chemicals or micro-organisms involved (hazardous or otherwise):</span><br>
                    {{ $form->coshhSection->chemicals_involved ?: 'N/A' }}
                </p>
            @endif
            <p>
                <span class="fw-bold">Should the work be carried out on the open bench, using other local exhaust ventilation, in a fume cupboard or in a glove box?</span><br>
                {{ $form->coshhSection->work_site ?: 'N/A' }}
            </p>
            <p>
                <span class="fw-bold">Disposal methods for materials used and wastes produced (if any):</span><br>
                {{ $form->coshhSection->disposal_methods ?: 'N/A' }}
            </p>
            <p>
                <span class="fw-bold">Further information not already covered:</span><br>
                {{ $form->coshhSection->further_risks ?: 'N/A' }}
            </p>
        </div>
    </div>
</div>
