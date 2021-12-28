<div class="row justify-content-center">
    <div class="col col-lg-9 mt-3">
        <div class="d-grid d-md-flex justify-content-md-end mb-2">
            <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                + Create
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a class="dropdown-item" href="{{ route('form.create', [
                        'type' => 'General'
                    ]) }}">General</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('form.create', [
                        'type' => 'Chemical'
                    ]) }}">Chemical</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('form.create', [
                        'type' => 'Biological'
                    ]) }}">Biological</a>
                </li>
            </ul>
        </div>


        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" id="bologna-list" role="tablist">
                    <li class="nav-item" role="presentation" wire:ignore>
                        <button class="nav-link active" id="my-forms-tab" data-bs-toggle="tab" data-bs-target="#my-forms" type="button" role="tab" aria-controls="my-forms" aria-selected="true">My Forms</button>
                    </li>
                    <li class="nav-item" role="presentation" wire:ignore>
                        <button class="nav-link" id="all-forms-tab" data-bs-toggle="tab" data-bs-target="#all-forms" type="button" role="tab" aria-controls="all-forms" aria-selected="true">All Forms</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">

                <div class="input-group mb-2">
                    <div class="input-group-text">
                        Status
                    </div>
                    <button wire:click.prevent="$set('statusFilter', '')"
                        class="input-group-text @if($statusFilter == '') bg-primary text-light @else bg-light @endif">
                        All
                    </button>
                    <button wire:click.prevent="$set('statusFilter', 'Approved')"
                        class="input-group-text @if($statusFilter == 'Approved') bg-primary text-light @else bg-light @endif">
                        <span class="icon-spacing">
                            <i class="fas fa-check"></i>
                        </span>
                        Approved
                    </button>
                    <button wire:click.prevent="$set('statusFilter', 'Pending')"
                        class="input-group-text @if($statusFilter == 'Pending') bg-primary text-light @else bg-light @endif">
                        <span class="icon-spacing">
                            <i class="fas fa-hourglass-half"></i>
                        </span>
                        Pending
                    </button>
                    <button wire:click.prevent="$set('statusFilter', 'Rejected')"
                        class="input-group-text @if($statusFilter == 'Rejected') bg-primary text-light @else bg-light @endif">
                        <span class="icon-spacing">
                            <i class="fas fa-times"></i>
                        </span>
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

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="my-forms" role="tabpanel" aria-labelledby="my-forms-tab" wire:ignore.self>
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
                    <div class="tab-pane fade" id="all-forms" role="tabpanel" aria-labelledby="all-forms-tab" wire:ignore.self>
                        <table class="table table-borderless border rounded-3">
                            <thead class="table-light">
                                <tr>
                                    @if (! $allForms->count())
                                        <td class="text-center fw-bold" colspan="3">No forms to show.</td>
                                    @else
                                        @include('livewire.partials.table-headers')
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="border">
                                @include('livewire.partials.table-row', ['forms' => $allForms])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
