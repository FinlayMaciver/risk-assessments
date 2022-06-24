<div class="card">
    <div class="card-header fw-bold">Hazards of micro-organisms involved</div>
    <div class="card-body">
        @foreach($microOrganisms as $index => $microOrganism)
            <div class="card">
                <div class="card-header fw-bold">
                    Micro-organism {{ $index+1 }}
                    <div wire:click="deleteMicroOrganism({{$index}})" class="float-end cursor-pointer">
                        <span class="fa-solid fa-times text-danger"></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('microOrganisms.*.micro_organism') is-invalid @enderror" placeholder="Micro-organism" name="micro_organism" wire:model="microOrganisms.{{$index}}.micro_organism">
                                <label for="micro_organism">Micro-organism</label>
                                @error('microOrganisms.*.micro_organism') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="classification" wire:model="microOrganisms.{{$index}}.classification" class="form-select @error('microOrganisms.*.classification') is-invalid @enderror">
                                    <option selected>---</option>
                                    @foreach([
                                        'ACDP Class 1',
                                        'ACDP Class 2',
                                        'ACDP Class 3',
                                        'ACDP Class 4',
                                    ] as $classification)
                                        <option value="{{ $classification }}">{{ $classification }}</option>
                                    @endforeach
                                </select>
                                <label for="classification" class="form-label">Hazard Classification</label>
                                @error('microOrganisms.*.classification') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="risk" wire:model="microOrganisms.{{$index}}.risk" class="form-select @error('microOrganisms.*.risk') is-invalid @enderror">
                                    <option selected>---</option>
                                    @foreach([
                                        'Low',
                                        'Medium',
                                        'High'
                                    ] as $risk)
                                        <option value="{{ $risk }}">{{ $risk }}</option>
                                    @endforeach
                                </select>
                                <label for="risk" class="form-label">Risk to user or others</label>
                                @error('microOrganisms.*.risk') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="single_acute_effect" wire:model="microOrganisms.{{$index}}.single_acute_effect" class="form-select @error('microOrganisms.*.single_acute_effect') is-invalid @enderror">
                                    <option value="" selected>---</option>
                                    @foreach([
                                        'Serious',
                                        'Not serious',
                                        'Not known',
                                    ] as $effect)
                                        <option value="{{ $effect }}">{{ $effect }}</option>
                                    @endforeach
                                </select>
                                <label for="single_acute_effect" class="form-label">Effect of single acute exposure</label>
                                @error('microOrganisms.*.single_acute_effect') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="repeated_low_effect" wire:model="microOrganisms.{{$index}}.repeated_low_effect" class="form-select @error('microOrganisms.*.repeated_low_effect') is-invalid @enderror">
                                    <option value="" selected>---</option>
                                    @foreach([
                                        'Serious',
                                        'Not serious',
                                        'Not known',
                                    ] as $effect)
                                        <option value="{{ $effect }}">{{ $effect }}</option>
                                    @endforeach
                                </select>
                                <label for="repeated_low_effect" class="form-label">Effect of repeated low exposure</label>
                                @error('microOrganisms.*.repeated_low_effect') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <label for="route">Route by which micro-organism is hazardous to health</label>
                            @livewire('multi-select', [
                                'mainModel' => 'MicroOrganism',
                                'optionsModel' => 'Route',
                                'selected' => $microOrganism->routes->pluck('id'),
                                'descriptors' => [
                                    'title',
                                ],
                                'index' => $index,
                            ], key($index+1))
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
        <div class="d-grid">
            <button wire:click.prevent="addMicroOrganism" class="btn btn-primary fw-bold">+ Add a micro-organism</button>
        </div>
    </div>
</div>
<hr>
