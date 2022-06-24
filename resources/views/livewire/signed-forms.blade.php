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

                @include('livewire.partials.generic_form_table')
            </div>
        </div>
    </div>
</div>
