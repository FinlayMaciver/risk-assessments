<div class="card">
    <div class="card-header fw-bold">Users</div>
    <div class="card-body">
        <div class="mb-3">
            <label for="multi_user">Allow other users to sign off on this form?</label>
            <div class="form-check form-switch">
                <input name="multi" wire:model="form.multi_user" class="form-check-input" type="checkbox">
            </div>
        </div>
        <hr>
        <div class="mb-3">
            @livewire('form.partials.supervisor-search', ['type' => 'supervisor', 'user' => $form['supervisor']])
        </div>
        <hr>
        <div class="mb-3">
            <label for="reviewers">Reviewers</label>
            @foreach ($reviewers as $index => $reviewer)
                @livewire('form.partials.reviewer-search', ['reviewer' => $reviewer, 'index' => $index], key($index+1))
                <br>
            @endforeach
        </div>
        <div class="d-grid">
            <button wire:click.prevent="addReviewer" class="btn btn-primary fw-bold">+ Add a reviewer</button>
        </div>
    </div>
</div>
<br>
