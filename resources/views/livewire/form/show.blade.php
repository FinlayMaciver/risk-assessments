<div class="row justify-content-center">
    <div class="col col-lg-9 mt-3">
        <h2 class="text-center mb-2">@if($form->is_archived) <i>(Archived)</i> - @endif{{ $form->title }}</h2>


        <div class="d-print-none d-grid d-md-flex justify-content-md-end mb-2">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    More...
                </button>
                <ul class="dropdown-menu">
                    @can('edit-form', $form)
                    <li>
                        <a href="{{ route('form.edit', $form->id) }}" class="dropdown-item" type="button">
                            <i class="fa-solid fa-edit me-1"></i> Edit
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @endcan
                    <li>
                        <a href="{{ route('form.replicate', $form->id) }}" class="dropdown-item" type="button">
                            <i class="fa-solid fa-copy"></i> Replicate
                        </a>
                    </li>
                    <li>
                        <button onCLick="window.print()" class="dropdown-item" type="button">
                            <i class="fa-solid fa-print"></i> Print
                        </button>
                    </li>
                </ul>
            </div>

        </div>

        <div class="row mb-3">
            @include('form.show.details')
            @include('form.show.users')
        </div>
        <div class="row mb-3">
            @include('form.show.risks')
        </div>
        @if ($form->type == 'Biological')
        <div class="row mb-3">
            @include('form.show.micro-organisms')
        </div>
        @endif
        @if ($form->type == 'Biological' || $form->type == 'Chemical')
            <div class="row mb-3">
                @include('form.show.substances')
            </div>
            <div class="row mb-3">
                @include('form.show.requirements')
                @include('form.show.information')
            </div>
        @endif
        @if($form->supervisor == auth()->user() && $form->supervisor_approval === null)
            <hr>
            @livewire('form.approval', [
                'form' => $form
            ])
        @endif
        @if ($form->multi_user && !$form->users->contains(auth()->user()))
                balegdeh
        @endif
    </div>
</div>
