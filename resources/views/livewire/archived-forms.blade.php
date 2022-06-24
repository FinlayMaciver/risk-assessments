<div class="row justify-content-center">
    <div class="col col-lg-9 mt-3">
        <h3 class="mt-5 mb-5 text-center">Archived Forms</h3>
        <div class="card">
            <div class="card-body">
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <i class="fa-solid fa-filter"></i>
                        <span class="ml-1 d-none d-lg-block">Type</span>
                    </div>
                    <button wire:click.prevent="$set('multiFilter', '')"
                        class="input-group-text @if($multiFilter === '') bg-primary text-light @else bg-white @endif">
                        Both
                    </button>
                    <button wire:click.prevent="$set('multiFilter', false)"
                        class="input-group-text @if($multiFilter === false) bg-primary text-light @else bg-white @endif">
                        Single user
                    </button>
                    <button wire:click.prevent="$set('multiFilter', true)"
                        class="input-group-text @if($multiFilter === true) bg-primary text-light @else bg-white @endif">
                        Multiple users
                    </button>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <i class="fa-solid fa-filter"></i>
                        <span class="ml-1 d-none d-lg-block">Status</span>
                    </div>
                    <button wire:click.prevent="$set('statusFilter', '')"
                        class="input-group-text @if($statusFilter == '') bg-primary text-light @else bg-white @endif">
                        All
                    </button>
                    <button wire:click.prevent="$set('statusFilter', 'Approved')"
                        class="input-group-text @if($statusFilter == 'Approved') bg-primary text-light @else bg-white @endif">
                        Approved
                    </button>
                    <button wire:click.prevent="$set('statusFilter', 'Pending')"
                        class="input-group-text @if($statusFilter == 'Pending') bg-primary text-light @else bg-white @endif">
                        Pending
                    </button>
                    <button wire:click.prevent="$set('statusFilter', 'Rejected')"
                        class="input-group-text @if($statusFilter == 'Rejected') bg-primary text-light @else bg-white @endif">
                        Rejected
                    </button>
                </div>

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
