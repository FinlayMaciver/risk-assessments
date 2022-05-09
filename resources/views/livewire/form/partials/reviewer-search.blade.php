<div class="col">
    <div class="input-group">
        <input name="reviewer-{{$index}}"
        wire:change="search" wire:model="email" type="text" class="form-control
            @if($valid)
                is-valid
            @elseif($valid === false)
                is-invalid
            @endif" placeholder="Reviewer's email">
        <button wire:click="delete" class="btn btn-outline-danger" type="button"><i class="fas fa-times"></i> Delete</button>
        <button wire:click="search" class="btn btn-outline-primary" type="button"><i class="fas fa-search"></i> Confirm</button>
    </div>
    @if($valid === false)
    <div class="text-danger">
        Invalid email address.
    </div>
    @endif
</div>
