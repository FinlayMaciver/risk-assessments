<div class="row justify-content-center">
    <div class="col col-lg-9 mt-3">
        <h2 class="text-center mb-2">{{ $form->title }}</h2>

        @if (auth()->user() == $form->user)
            <div class="d-grid d-md-flex justify-content-md-end mb-2">
                <a href="{{ route('form.edit', $form->id) }}" class="btn btn-primary" type="button">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        @endif

        <div class="row mb-3">
            @include('form.show.users')
            @include('form.show.details')
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
