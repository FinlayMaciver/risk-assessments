<div class="card">
    <div class="card-header fw-bold">Users</div>
    <div class="card-body">
        <div class="row">
            @livewire('form.partials.supervisor-search', ['type' => 'supervisor', 'user' => $form['supervisor']])
            @livewire('form.partials.supervisor-search', ['type' => 'lab guardian', 'user' => $form['labGuardian']])
        </div>
        <hr>
        <div class="mb-3">
            <label for="multi_user">Multiple users?</label>
            <div class="form-check form-switch">
                <input name="multi" wire:model="form.multi_user" class="form-check-input" type="checkbox">
            </div>
        </div>
        @if ($form->multi_user)
            You may add some users yourself here to notify them of the form being submitted. Users not listed here can still sign off the form.
            @foreach ($users as $index => $user)
                @livewire('form.partials.user-search', ['user' => $user, 'index' => $index], key($index+1))
                <br>
            @endforeach
            <div class="d-grid">
                <button wire:click.prevent="addUser" class="btn btn-primary">+ Add a user</button>
            </div>
        @endif
    </div>
</div>
<br>
