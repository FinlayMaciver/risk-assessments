<div class="card">
    <div class="card-header fw-bold">Potential risks involved in preparing for or carrying out work</div>
    <div class="card-body">
        @foreach($risks as $index => $risk)
            <div class="card">
                <div class="card-header fw-bold">
                    Risk {{ $index+1 }}
                    <div wire:click="deleteRisk({{$index}})" class="float-end cursor-pointer">
                        <span class="fas fa-times text-danger"></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control @error('risks.*.hazard') is-invalid @enderror" name="hazard" wire:model="risks.{{$index}}.hazard"></textarea>
                                <label for="hazard">Hazard</label>
                                @error('risks.*.hazard') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control @error('risks.*.consequences') is-invalid @enderror" name="consequences" wire:model="risks.{{$index}}.consequences"></textarea>
                                <label for="risk">Consequences</label>
                                @error('risks.*.consequences') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select
                                    name="likelihood_without"
                                    wire:model="risks.{{$index}}.likelihood_without"
                                    wire:change="updateRiskRating({{$index}})"
                                    class="form-select @error('risks.*.likelihood_without') is-invalid @enderror">
                                    <option value="" selected>---</option>
                                        @foreach($likelihoods as $likelihood)
                                            <option value="{{ $likelihood->id }}">{{ $likelihood->value }} - {{ $likelihood->title }}</option>
                                        @endforeach
                                </select>
                                <label for="likelihood_without" class="form-label">Likelihood <b><u>without</u></b> control measures</label>
                                @error('risks.*.likelihood_without') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select
                                    name="impact_without"
                                    wire:model="risks.{{$index}}.impact_without"
                                    wire:change="updateRiskRating({{$index}})"
                                    class="form-select @error('risks.*.impact_without') is-invalid @enderror">
                                    <option value="" selected>---</option>
                                        @foreach($impacts as $impact)
                                            <option value="{{ $impact->id }}">{{ $impact->value }} - {{ $impact->title }}</option>
                                        @endforeach
                                </select>
                                <label for="impact_without" class="form-label">Impact <b><u>without</u></b> control measures</label>
                                @error('risks.*.impact_without') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if ($risk->rating_without)
                            <div class="col-md-12">
                                <div
                                    class="alert
                                        @if($risk->rating_without <= 6) alert-success
                                        @elseif($risk->rating_without <= 12) alert-warning
                                        @else alert-danger
                                        @endif"
                                    role="alert">
                                    <b>Risk rating: {{ $risk->rating_without }}</b> - {{ $risk->blurb_without }}
                                </div>
                            </div>
                        @endif

                        <hr>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea name="control_measures" wire:model="risks.{{$index}}.control_measures" class="form-control @error('risks.*.control_measures') is-invalid @enderror"></textarea>
                                <label for="control_measures">Control measures to mitigate risk, consequences of an incident, and how to deal with it where necessary</label>
                                @error('risks.*.control_measures') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select
                                    name="likelihood_with"
                                    wire:model="risks.{{$index}}.likelihood_with"
                                    wire:change="updateRiskRating({{$index}})"
                                    class="form-select @error('risks.*.likelihood_with') is-invalid @enderror">
                                    <option value="" selected>---</option>
                                    @foreach($likelihoods as $likelihood)
                                        <option value="{{ $likelihood->id }}">{{ $likelihood->value }} - {{ $likelihood->title }}</option>
                                    @endforeach
                                </select>
                                <label for="likelihood_with" class="form-label">Likelihood <b><u>with</u></b> control measures</label>
                                @error('risks.*.likelihood_with') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select
                                    name="impact_with"
                                    wire:model="risks.{{$index}}.impact_with"
                                    wire:change="updateRiskRating({{$index}})"
                                    class="form-select @error('risks.*.impact_with') is-invalid @enderror">
                                    <option value="" selected>---</option>
                                    @foreach($impacts as $impact)
                                        <option value="{{ $impact->id }}">{{ $impact->value }} - {{ $impact->title }}</option>
                                    @endforeach
                                </select>
                                <label for="impact_with" class="form-label">Impact <b><u>with</u></b> control measures</label>
                                @error('risks.*.impact_with') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if ($risk->rating_with)
                            <div class="col-md-12">
                                <div
                                    class="alert
                                        @if($risk->rating_with <= 6) alert-success
                                        @elseif($risk->rating_with <= 12) alert-warning
                                        @else alert-danger
                                        @endif"
                                    role="alert">
                                    <b>Risk rating: {{ $risk->rating_with }}</b> - {{ $risk->blurb_with }}
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea name="comments" wire:model="risks.{{$index}}.comments" class="form-control @error('risks.*.comments') is-invalid @enderror"></textarea>
                                <label for="comments">Additional comments</label>
                                @error('risks.*.comments') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
        <div class="d-grid">
            <button wire:click.prevent="addRisk" class="btn btn-primary fw-bold">+ Add a risk</button>
        </div>
    </div>
</div>
<hr>
