<div class="col">
    <div class="card">
        <div class="card-header text-center fw-bold">Hazardous substances involved</div>
        <div class="card-body">
            @if (! $form->substances->count())
                <h6 class="fst-italic text-muted text-center">No substances</h6>
            @else
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($form->substances as $index => $substance)
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-header text-center">
                                    <h6 class="fw-bold mb-0">Substance {{ $index + 1 }}</h6>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <span class="fw-bold">
                                            Substance:
                                        </span>
                                        <br>
                                        {{ $substance->substance }}
                                    </p>
                                    <p>
                                        <span class="fw-bold">
                                            Quantity:
                                        </span>
                                        <br>
                                        {{ $substance->quantity }}
                                    </p>
                                    <p>
                                        <span class="fw-bold">
                                            Route by which substance is hazardous to health:
                                        </span>
                                        <br>
                                        @foreach ($substance->routes as $route)
                                            <span class="badge bg-primary">{{ $route->title }}</span>
                                        @endforeach
                                    </p>
                                    <p>
                                        <span class="fw-bold">
                                            Hazard classification:
                                        </span>
                                        <br>
                                        @foreach ($substance->hazards as $hazard)
                                            <span class="badge bg-primary">{{ $hazard->title }}</span>
                                        @endforeach
                                    </p>
                                    <p>
                                        <span class="fw-bold">
                                            Effect of single acute exposure:
                                        </span>
                                        <br>
                                        {{ $substance->single_acute_effect }}
                                    </p>
                                    <p>
                                        <span class="fw-bold">
                                            Effect of repeated low exposure:
                                        </span>
                                        <br>
                                        {{ $substance->repeated_low_effect }}
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
