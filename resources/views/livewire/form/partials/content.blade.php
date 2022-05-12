<div>
    <input type="hidden" name="id" wire:model="form.id">
    <input type="hidden" name="user_id" wire:model="form.user_id">
    <input type="hidden" name="supervisor_id" wire:model="form.supervisor_id">

    @include('form.partials.overview')

    @include('form.partials.users')

    @include('form.partials.risks')

    @if ($form->type == 'Biological')
        @include('form.partials.micro-organisms')
    @endif

    @if ($form->type == 'Biological' || $form->type == 'Chemical')

        @include('form.partials.substances')
        @include('form.partials.protection')
        @include('form.partials.supervision')
        @include('form.partials.monitoring')
        @include('form.partials.contingency')
        @include('form.partials.emergency')
        @include('form.partials.informing')
        @include('form.partials.control')
    @endif

    @include('form.partials.files')

    <hr>
    <div class="d-grid mb-5">
        @if(!$valid || count($errors))
            <button disabled class="btn btn-danger"> You have some errors in your form, please correct them</button>
        @else
            <button wire:click.prevent="save" class="btn btn-success">Save</button>
        @endif
    </div>
</div>
