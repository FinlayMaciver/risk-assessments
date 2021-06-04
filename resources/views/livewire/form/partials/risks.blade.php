<div class="card">
    <div class="card-header fw-bold">Potential risks involved in preparing for or carrying out work</div>
    <div class="card-body">
        @foreach($this->risks as $index => $risk)
            <div class="card">
                <div class="card-header fw-bold">Risk {{ $index+1 }}</div>
                <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Risk" wire:change="update" name="description" wire:model="risks.{{$index}}.description"></textarea>
                            <label for="description">Risk</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select wire:change="update" name="severity" wire:model="risks.{{$index}}.severity" class="form-select">
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
                        </div>
                        @error('risks.{{$index}}.severity') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea wire:change="update" name="control_measures" wire:model="risks.{{$index}}.control_measures" class="form-control"></textarea>
                            <label for="control_measures">Control measures to mitigate risk, consequences of an incident, and how to deal with it where necessary</label>
                        </div>
                        @error('risks.{{$index}}.control_measures') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select wire:change="update"  name="likelihood_without" wire:model="risks.{{$index}}.likelihood_without" class="form-select">
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
                        </div>
                        @error('risks.{{$index}}.likelihood_without') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select wire:change="update" name="likelihood_with" wire:model="risks.{{$index}}.likelihood_with" class="form-select">
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
                        </div>
                        @error('risks.{{$index}}.likelihood_with') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                </div>
            </div>
            <hr>
        @endforeach
        <div class="d-grid">
            <button wire:click.prevent="add" class="btn btn-outline-info">+ Add another risk</button>
        </div>
    </div>
</div>
<br>
