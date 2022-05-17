<th class="d-none d-md-table-cell cursor-pointer" wire:click.prevent="toggleSort('title')">
    Title
    @if ($orderBy['column'] == 'title')
        @if ($orderBy['order'] == 'asc')
            <i class="fa-solid fa-sort-alpha-down"></i>
        @else
            <i class="fa-solid fa-sort-alpha-down-alt"></i>
        @endif
    @else
        <i class="fa-solid fa-sort sort-icon"></i>
    @endif
</th>
<th class="d-none d-md-table-cell cursor-pointer" wire:click.prevent="toggleSort('location')">
    Location
    @if ($orderBy['column'] == 'location')
        @if ($orderBy['order'] == 'asc')
            <i class="fa-solid fa-sort-alpha-down"></i>
        @else
            <i class="fa-solid fa-sort-alpha-down-alt"></i>
        @endif
    @else
        <i class="fa-solid fa-sort sort-icon"></i>
    @endif
</th>
<th class="d-none d-md-table-cell cursor-pointer" wire:click.prevent="toggleSort('forms.created_at')">
    Uploaded
    @if ($orderBy['column'] == 'forms.created_at')
        @if ($orderBy['order'] == 'asc')
            <i class="fa-solid fa-sort-alpha-down"></i>
        @else
            <i class="fa-solid fa-sort-alpha-down-alt"></i>
        @endif
    @else
        <i class="fa-solid fa-sort sort-icon"></i>
    @endif
</th>
<th class="d-none d-md-table-cell cursor-pointer" wire:click.prevent="toggleSort('forms.updated_at')">
    Updated
    @if ($orderBy['column'] == 'forms.updated_at')
        @if ($orderBy['order'] == 'asc')
            <i class="fa-solid fa-sort-alpha-down"></i>
        @else
            <i class="fa-solid fa-sort-alpha-down-alt"></i>
        @endif
    @else
        <i class="fa-solid fa-sort sort-icon"></i>
    @endif
</th>
<th class="d-none d-md-table-cell cursor-pointer" wire:click.prevent="toggleSort('users.forenames')">
    User
    @if ($orderBy['column'] == 'users.forenames')
        @if ($orderBy['order'] == 'asc')
            <i class="fa-solid fa-sort-alpha-down"></i>
        @else
            <i class="fa-solid fa-sort-alpha-down-alt"></i>
        @endif
    @else
        <i class="fa-solid fa-sort sort-icon"></i>
    @endif
</th>
<th class="d-none d-md-table-cell cursor-pointer" wire:click.prevent="toggleSort('status')">
    Status
    @if ($orderBy['column'] == 'status')
        @if ($orderBy['order'] == 'asc')
            <i class="fa-solid fa-sort-alpha-down"></i>
        @else
            <i class="fa-solid fa-sort-alpha-down-alt"></i>
        @endif
    @else
        <i class="fa-solid fa-sort sort-icon"></i>
    @endif
</th>
