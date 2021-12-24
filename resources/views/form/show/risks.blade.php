<div class="col">
    <div class="card">
        <div class="card-header text-center fw-bold">Potential risks involved in preparing for or carrying out work</div>
        <div class="card-body">
            @foreach($form->risks as $index => $risk)
            <div class="card mb-3">
                <div class="card-header text-center">
                    Risk {{ $index + 1 }} - <b>Severity: {{ $risk->severity }} </b>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <span class="fw-bold">Description</span><br>
                            {{ $risk->risk }}
                        </div>
                        <div class="col">
                            <span class="fw-bold">Control measures</span><br>
                            {{ $risk->control_measures }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <span class="fw-bold">Likelihood without control measures</span><br>
                            {{ $risk->likelihood_without }}
                        </div>
                        <div class="col">
                            <span class="fw-bold">Likelihood with control measures</span><br>
                            {{ $risk->likelihood_with }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if (! $form->risks->count())
                <div class="fst-italic text-muted text-center">No risks</div>
            @endif
        </div>
    </div>
</div>
