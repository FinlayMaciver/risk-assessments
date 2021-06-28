<div class="card">
    <div class="card-header fw-bold">Hazardous substances and micro-organisms involved</div>
    <div class="card-body">
        @foreach($this->substances as $index => $substance)
            <div class="card">
                <div class="card-header fw-bold">
                    Substance {{ $index+1 }}
                    <div wire:click="delete({{$index}})" class="float-end cursor-pointer">
                        <span class="fas fa-times text-danger"></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Substance" wire:change="update" name="substance" wire:model="substances.{{$index}}.substance">
                                <label for="substance">Substance</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <select wire:change="update" name="quantity" wire:model="substances.{{$index}}.quantity" class="form-select">
                                    <option selected>---</option>
                                    @foreach([
                                        'Small < 10mg',
                                        'Moderate 10mg - 10g',
                                        'Large 10g - 100g',
                                        'Very large > 100g',
                                    ] as $quantity)
                                        <option value="{{ $quantity }}">{{ $quantity }}</option>
                                    @endforeach
                                </select>
                                <label for="quantity" class="form-label">Quantity</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select wire:change="update" name="single_acute_effect" wire:model="substances.{{$index}}.single_acute_effect" class="form-select">
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
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select wire:change="update" name="repeated_low_effect" wire:model="substances.{{$index}}.repeated_low_effect" class="form-select">
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
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="hazards">Hazard Classification</label>
                            @livewire('multi-select', [
                                'mainModel' => 'Substance',
                                'optionsModel' => 'Hazard',
                                'selected' => $substance->hazards->pluck('id'),
                                'descriptors' => [
                                    'title',
                                ],
                                'index' => $index,
                            ])
                        </div>
                        <div class="col-md-6">
                            <label for="route">Route by which substance is hazardous to health</label>
                            @livewire('multi-select', [
                                'mainModel' => 'Substance',
                                'optionsModel' => 'Route',
                                'selected' => $substance->routes->pluck('id'),
                                'descriptors' => [
                                    'title',
                                ],
                                'index' => $index,
                            ])
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
        <div class="d-grid">
            <button wire:click.prevent="add" class="btn btn-primary">+ Add a substance</button>
        </div>
    </div>
</div>
