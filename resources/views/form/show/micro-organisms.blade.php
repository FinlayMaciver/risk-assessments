<div class="col">
    <div class="card">
        <div class="card-header text-center fw-bold">Hazards of micro-organisms involved</div>
        <div class="card-body">
            @foreach($form->microOrganisms as $index => $microOrganism)
            <div class="card mb-3">
                <div class="card-header text-center">
                    Micro-organism {{ $index + 1 }} - {{ $microOrganism->micro_organism }}
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <span class="fw-bold">Route by which micro-organism is hazardous to health</span><br>
                            @foreach ($microOrganism->routes as $route)
                                <span class="badge bg-primary">{{ $route->title }}</span>
                            @endforeach
                        </div>
                        <div class="col">
                            <span class="fw-bold">Hazard classification</span><br>
                            {{ $microOrganism->classification }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <span class="fw-bold">Effect of single acute exposure</span><br>
                            {{ $microOrganism->single_acute_effect }}
                        </div>
                        <div class="col">
                            <span class="fw-bold">Effect of repeated low exposure</span><br>
                            {{ $microOrganism->repeated_low_effect }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if (! $form->microOrganisms->count())
                <div class="fst-italic text-muted text-center">No micro-organisms</div>
            @endif
        </div>
    </div>
</div>
