<div class="col">
    <div class="card">
        <div class="card-header text-center fw-bold">Hazards of micro-organisms involved</div>
        <div class="card-body">
            @if (! $form->microOrganisms->count())
                <h6 class="fst-italic text-muted text-center">No micro-organisms</h6>
            @else
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach($form->microOrganisms as $index => $microOrganism)
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-header text-center">
                                <h6 class="fw-bold mb-0">Micro-organism {{ $index + 1 }}</h6>
                            </div>
                            <div class="card-body">
                                <p>
                                    <span class="fw-bold">Micro-organism:</span><br>{{  $microOrganism->micro_organism }}
                                </p>
                                <p>
                                    <span class="fw-bold">Hazard classification:</span><br>{{ $microOrganism->classification }}
                                </p>
                                <p>
                                    <span class="fw-bold">Route by which micro-organism is hazardrous to health</span><br>
                                    @foreach ($microOrganism->routes as $route)
                                        <span class="badge bg-primary">{{ $route->title }}</span>
                                    @endforeach
                                <p>
                                    <span class="fw-bold">Effect of single acute exposure:</span><br>{{ $microOrganism->single_acute_effect }}
                                </p>
                                <p>
                                    <span class="fw-bold">Effect of repeated low exposure:</span><br>{{ $microOrganism->repeated_low_effect }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
