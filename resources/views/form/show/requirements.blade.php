<div class="col-md-6">
    <div class="card">
        <div class="card-header text-center fw-bold">Requirements</div>
        <div class="card-body">
        @if($form->no_requirements)
            <div class="fst-italic text-muted text-center">No requirements</div>
        @else
            <ul class="mb-0">
                <!-- Protection -->
                @if ($form->eye_protection)
                    <li>Eye protection</li>
                @endif
                @if ($form->face_protection)
                    <li>Face protection</li>
                @endif
                @if ($form->hand_protection)
                    <li>Hand protection</li>
                @endif
                @if ($form->foot_protection)
                    <li>Foot protection</li>
                @endif
                @if ($form->respiratory_protection)
                    <li>Respiratory protection</li>
                @endif
                @if ($form->other_protection)
                    <li>{{ $form->other_protection }}</li>
                @endif

                <!-- Emergency -->
                @if ($form->instructions)
                    <li>Written emergency instructions</li>
                @endif
                @if ($form->spill_neutralisation)
                    <li>Spill neutralisation chemicals</li>
                @endif
                @if ($form->eye_irrigation)
                    <li>Eye irrigation point</li>
                @endif
                @if ($form->body_shower)
                    <li>Body shower</li>
                @endif
                @if ($form->first_aid)
                    <li>First aid provisions</li>
                @endif
                @if ($form->breathing_apparatus)
                    <li>Breathing apparatus (with trained operator)</li>
                @endif
                @if ($form->external_services)
                    <li>External emergency services</li>
                @endif
                @if ($form->poison_antidote)
                    <li>Poison antidote</li>
                @endif
                @if ($form->other_emergency)
                    <li>{{ $form->other_emergency }}</li>
                @endif

                <!-- Supervision -->
                @if ($form->routine_approval)
                    <li>Supervisor approves straightforward and routine work</li>
                @endif
                @if ($form->specific_approval)
                    <li>Supervisor will specifically approve the scheme of work outlined above</li>
                @endif
                @if ($form->personal_supervision)
                    <li>Supervisor will provide personal supervision to control and oversee the work</li>
                @endif

                <!-- Monitoring -->
                @if ($form->airborne_monitoring)
                    <li>Monitoring of airborne contaminents</li>
                @endif
                @if ($form->biological_monitoring)
                    <li>Biological monitoring of workers</li>
                @endif

                <!-- Informing -->
                @if ($form->inform_lab_occupants)
                    <li>Inform others working in the lab</li>
                @endif
                @if ($form->inform_cleaners)
                    <li>Inform cleaners</li>
                @endif
                @if ($form->inform_contractors)
                    <li>Inform contractors</li>
                @endif
                @if ($form->inform_other)
                    <li>{{ $form->inform_other }}
                @endif
            </ul>
        @endif
        </div>
    </div>
</div>
