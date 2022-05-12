<div class="row justify-content-center">
    <div class="col col-lg-9 mt-3">
        <div class="d-grid d-md-flex justify-content-md-end mb-2">
            <a href="{{ route('form.create') }}" class="btn btn-success" type="button">
                + Create
            </a>
        </div>

        <div class="card">
            <div class="card-header">My Forms</div>
            <div class="card-body">
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <i class="fas fa-filter"></i>
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
                        <i class="fas fa-filter"></i>
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
                        <i class="fas fa-search"></i>
                    </div>
                    <label class="sr-only" for="search">Search</label>
                    <input id="search" class="form-control" type="text" wire:model="search" placeholder="Search...">
                </div>

                <table class="table table-borderless border rounded-3">
                    <thead class="table-light">
                        <tr>
                            @if (! $myForms->count())
                                <td class="text-center fw-bold" colspan="3">No forms to show.</td>
                            @else
                                @include('livewire.partials.table-headers')
                            @endif
                        </tr>
                    </thead>
                    <tbody class="border">
                        @include('livewire.partials.table-row', ['forms' => $myForms])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
