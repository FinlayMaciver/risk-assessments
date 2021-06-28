<div>
    <div class="d-inline-block mb-1">
        @foreach ($selected as $selectedItem)
            <span wire:click.prevent="update({{$selectedItem->id}})" class="badge rounded-pill bg-primary">
                <span class="fas fa-times"></span>
                @foreach ($descriptors as $index=>$descriptor)
                    {{ $selectedItem->$descriptor }}
                    @if ($index < count($descriptors) - 1)
                    -
                    @endif
                @endforeach
            </span>
        @endforeach
    </div>
    <select class="form-select" wire:change="update($event.target.value);">
        <option selected disabled>+ Add</option>
        @foreach ($options as $option)
            <option value="{{ $option->id }}">
                @foreach ($descriptors as $index=>$descriptor)
                    {{ $option->$descriptor }}
                    @if ($index < count($descriptors) - 1)
                    -
                    @endif
                @endforeach
            </option>
        @endforeach
    </select>
</div>
