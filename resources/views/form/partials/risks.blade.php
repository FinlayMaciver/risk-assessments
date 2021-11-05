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
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <textarea class="form-control @error('risks.*.risk') is-invalid @enderror" placeholder="Risk" name="risk" wire:model="risks.{{$index}}.risk"></textarea>
                            <label for="risk">Risk</label>
                            @error('risks.*.risk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="severity" wire:model="risks.{{$index}}.severity" class="form-select @error('risks.*.severity') is-invalid @enderror">
                                <option selected>---</option>
                                @foreach([
                                    'Slight',
                                    'Moderate',
                                    'Very',
                                    'Extreme'
                                ] as $severity)
                                    <option value="{{ $severity }}">{{ $severity }}</option>
                                @endforeach
                            </select>
                            <label for="severity" class="form-label">Severity</label>
                            @error('risks.*.severity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="control_measures" wire:model="risks.{{$index}}.control_measures" class="form-control @error('risks.*.control_measures') is-invalid @enderror"></textarea>
                            <label for="control_measures">Control measures to mitigate risk, consequences of an incident, and how to deal with it where necessary</label>
                            @error('risks.*.control_measures') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select  name="likelihood_without" wire:model="risks.{{$index}}.likelihood_without" class="form-select @error('risks.*.likelihood_without') is-invalid @enderror">
                                <option value="" selected>---</option>
                                @foreach([
                                    'Improbable',
                                    'Unlikely',
                                    'Likely',
                                    'Very likely'
                                    ] as $likelihood)
                                    <option value="{{ $likelihood }}">{{ $likelihood }}</option>
                                    @endforeach
                            </select>
                            <label for="likelihood_without" class="form-label">Likelihood <b><u>without</u></b> control measures</label>
                            @error('risks.*.likelihood_without') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="likelihood_with" wire:model="risks.{{$index}}.likelihood_with" class="form-select @error('risks.*.likelihood_with') is-invalid @enderror">
                                <option value="" selected>---</option>
                                @foreach([
                                    'Improbable',
                                    'Unlikely',
                                    'Likely',
                                    'Very likely'
                                ] as $likelihood)
                                    <option value="{{ $likelihood }}">{{ $likelihood }}</option>
                                @endforeach
                            </select>
                            <label for="likelihood_with" class="form-label">Likelihood <b><u>with</u></b> control measures</label>
                            @error('risks.*.likelihood_with') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <hr>
        @endforeach
        <div class="d-grid">
            <button wire:click.prevent="addRisk" class="btn btn-primary">+ Add a risk</button>
        </div>
    </div>
</div>
<hr>
