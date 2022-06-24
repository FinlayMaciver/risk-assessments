<div class="col-md-6 mb-3">
    <div class="card">
        <div class="card-header text-center fw-bold">Requirements</div>
        <div class="card-body">
        @if($form->no_requirements)
            <div class="fst-italic text-muted text-center">No requirements</div>
        @else
            <ul class="mb-0">
                <!-- Protection -->
                @if ($form->coshhSection->eye_protection)
                    <li>Eye protection</li>
                @endif
                @if ($form->coshhSection->face_protection)
                    <li>Face protection</li>
                @endif
                @if ($form->coshhSection->hand_protection)
                    <li>Hand protection</li>
                @endif
                @if ($form->coshhSection->foot_protection)
                    <li>Foot protection</li>
                @endif
                @if ($form->coshhSection->respiratory_protection)
                    <li>Respiratory protection</li>
                @endif
                @if ($form->coshhSection->other_protection)
                    <li>{{ $form->coshhSection->other_protection }}</li>
                @endif

                <!-- Emergency -->
                @if ($form->coshhSection->instructions)
                    <li>Written emergency instructions</li>
                @endif
                @if ($form->coshhSection->spill_neutralisation)
                    <li>Spill neutralisation chemicals</li>
                @endif
                @if ($form->coshhSection->eye_irrigation)
                    <li>Eye irrigation point</li>
                @endif
                @if ($form->coshhSection->body_shower)
                    <li>Body shower</li>
                @endif
                @if ($form->coshhSection->first_aid)
                    <li>First aid provisions</li>
                @endif
                @if ($form->coshhSection->breathing_apparatus)
                    <li>Breathing apparatus (with trained operator)</li>
                @endif
                @if ($form->coshhSection->external_services)
                    <li>External emergency services</li>
                @endif
                @if ($form->coshhSection->poison_antidote)
                    <li>Poison antidote</li>
                @endif
                @if ($form->coshhSection->other_emergency)
                    <li>{{ $form->coshhSection->other_emergency }}</li>
                @endif

                <!-- Supervision -->
                @if ($form->coshhSection->routine_approval)
                    <li>Supervisor approves straightforward and routine work</li>
                @endif
                @if ($form->coshhSection->specific_approval)
                    <li>Supervisor will specifically approve the scheme of work outlined above</li>
                @endif
                @if ($form->coshhSection->personal_supervision)
                    <li>Supervisor will provide personal supervision to control and oversee the work</li>
                @endif

                <!-- Monitoring -->
                @if ($form->coshhSection->airborne_monitoring)
                    <li>Monitoring of airborne contaminents</li>
                @endif
                @if ($form->coshhSection->biological_monitoring)
                    <li>Biological monitoring of workers</li>
                @endif

                <!-- Informing -->
                @if ($form->coshhSection->inform_lab_occupants)
                    <li>Inform others working in the lab</li>
                @endif
                @if ($form->coshhSection->inform_cleaners)
                    <li>Inform cleaners</li>
                @endif
                @if ($form->coshhSection->inform_contractors)
                    <li>Inform contractors</li>
                @endif
                @if ($form->coshhSection->inform_other)
                    <li>{{ $form->coshhSection->inform_other }}
                @endif
            </ul>
        @endif
        </div>
    </div>
</div>
