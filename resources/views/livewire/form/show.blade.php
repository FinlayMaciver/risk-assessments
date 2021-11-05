<div class="row justify-content-center">
    <div class="col col-lg-9 mt-3">
        <h2 class="text-center mb-5">{{ $form->title }}</h2>
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
        @endif
        <div class="row mb-3">
            @include('form.show.requirements')
            @include('form.show.information')
        </div>
    </div>
</div>
