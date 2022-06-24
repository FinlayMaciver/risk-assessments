<div class="col">
    <div class="card">
        <div class="card-header text-center fw-bold">Potential risks involved in preparing for or carrying out work</div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($form->risks as $index => $risk)
                <div class="col">
                    <div class="card mb-3">
                        <div class="card-header fw-bold">
                            <h6 class="fw-bold mb-0">Risk {{ $index + 1 }}
                            <span class="float-end">
                                <span class="badge @if($risk->rating_without <= 6) bg-success @elseif($risk->rating_without <= 12) bg-warning @else bg-danger @endif">{{ $risk->rating_without}}</span> | <span class="badge @if($risk->rating_with <= 6) bg-success @elseif($risk->rating_with <= 12) bg-warning @else bg-danger @endif">{{ $risk->rating_with}}</span>
                            </span>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <span class="fw-bold">Description</span><br>
                                    {{ $risk->hazard }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <span class="fw-bold">Consequences</span><br>
                                    {{ $risk->consequences }}
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center"><span class="mb-3 badge @if($risk->rating_without <= 6) bg-success @elseif($risk->rating_without <= 12) bg-warning @else bg-danger @endif">Risk rating without control measures: {{ $risk->rating_without}}</span></h5>
                            <div class="row">
                                <div class="col">
                                    <span class="fw-bold">Likelihood without control measures</span><br>
                                    {{ $risk->likelihoodWithout->title }}
                                </div>
                                <div class="col">
                                    <span class="fw-bold">Impact without control measures</span><br>
                                    {{ $risk->impactWithout->title }}
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center"><span class="mb-3 badge @if($risk->rating_with <= 6) bg-success @elseif($risk->rating_with <= 12) bg-warning @else bg-danger @endif">Risk rating with control mesaures: {{ $risk->rating_with}}</span></h5>
                            <div class="row mb-3">
                                <div class="col">
                                    <span class="fw-bold">Control Measures</span><br>
                                    {{ $risk->control_measures }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="fw-bold">Likelihood with control measures</span><br>
                                    {{ $risk->likelihoodWith->title }}
                                </div>
                                <div class="col">
                                    <span class="fw-bold">Impact with control measures</span><br>
                                    {{ $risk->impactWith->title }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <span class="fw-bold">Comments</span><br>
                                    {{ $risk->comments }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if (! $form->risks->count())
                <div class="fst-italic text-muted text-center mt-4">No risks</div>
            @endif
        </div>
    </div>
</div>
