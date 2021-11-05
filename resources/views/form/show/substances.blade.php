<div class="col">
    <div class="card">
        <div class="card-header text-center fw-bold">Hazardous substances involved</div>
        <div class="card-body">
            @foreach($form->substances as $index => $substance)
            <div class="card mb-3">
                <div class="card-header text-center">
                    Substance {{ $index + 1 }} - {{ $substance->substance }} ({{ $substance->quantity }})
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <span class="fw-bold">Route by which substance is hazardous to health</span><br>
                            @foreach ($substance->routes as $route)
                                <span class="badge bg-primary">{{ $route->title }}</span>
                            @endforeach
                        </div>
                        <div class="col">
                            <span class="fw-bold">Hazard classification</span><br>
                            @foreach ($substance->hazards as $hazard)
                                <span class="badge bg-primary">{{ $hazard->title }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <span class="fw-bold">Effect of single acute exposure</span><br>
                            {{ $substance->single_acute_effect }}
                        </div>
                        <div class="col">
                            <span class="fw-bold">Effect of repeated low exposure</span><br>
                            {{ $substance->repeated_low_effect }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if (! $form->substances->count())
                <div class="fst-italic text-muted text-center">No substances</div>
            @endif
        </div>
    </div>
</div>
