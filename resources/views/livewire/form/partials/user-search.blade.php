<div class="col">
    <label for="{{ Illuminate\Support\Str::snake($type) }}" class="form-label">{{ Illuminate\Support\Str::ucfirst($type) }} email</label>
    <div class="input-group">
        <input name="{{ Illuminate\Support\Str::snake($type) }}"
        wire:change="search" wire:model="email" type="text" class="form-control
            @if($valid)
                is-valid
            @elseif($valid === false)
                is-invalid
            @endif" placeholder="{{ Illuminate\Support\Str::ucfirst($type) }}'s email">
        <button wire:click="search" class="btn btn-outline-primary" type="button"><i class="fas fa-search"></i> Search</button>
    </div>
    @if($valid)
    <div class="text-success">
        Found user: {{ $user->forenames }} {{ $user->surname }}
    </div>
    @elseif($valid === false)
    <div class="text-danger">
        Invalid email address.
    </div>
    @endif
</div>
