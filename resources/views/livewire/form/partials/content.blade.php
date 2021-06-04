<div>
    <input type="hidden" name="id" wire:model="form.id">
    <input type="hidden" name="multi_user" wire:model="form.multi_user">
    <input type="hidden" name="user_id" wire:model="form.user_id">

    @include('form.partials.overview')

    @livewire('form.partials.risks', [
        'risks' => $form['risks']
    ])
    @include('form.partials.protection')

    @include('form.partials.supervision')

    @include('form.partials.monitoring')

    @include('form.partials.contingency')

    @include('form.partials.emergency')

    @include('form.partials.control')

    @include('form.partials.files')

    <button wire:click.prevent="save" class="btn btn-success">Save</button>
</div>
