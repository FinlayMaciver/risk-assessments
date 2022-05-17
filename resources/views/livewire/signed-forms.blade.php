<div class="row justify-content-center">
    <div class="col col-lg-9 mt-3">
        <h3 class="mt-5 mb-5 text-center">Signed Forms</h3>
        <div class="card">
            <div class="card-body">
                <div class="d-inline-flex input-group mb-2">
                    <div class="input-group-text">
                        <i class="fa-solid fa-search"></i>
                    </div>
                    <label class="sr-only" for="search">Search</label>
                    <input id="search" class="form-control" type="text" wire:model="search" placeholder="Search...">
                </div>

                <table class="table table-borderless border rounded-3">
                    <thead class="table-light">
                        <tr>
                            @if (! $signedForms->count())
                                <td class="text-center fw-bold" colspan="3">No forms to show.</td>
                            @else
                                @include('livewire.partials.table-headers')
                            @endif
                        </tr>
                    </thead>
                    <tbody class="border">
                        @include('livewire.partials.table-row', ['forms' => $signedForms])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
