<table class="table table-borderless border rounded-3">
    <thead class="table-light">
        <tr>
            @if (! $approvedForms->count())
                <td class="text-center fw-bold" colspan="3">No forms to show.</td>
            @else
                @include('livewire.partials.table-headers')
            @endif
        </tr>
    </thead>
    <tbody class="border">
        @include('livewire.partials.table-row', ['forms' => $approvedForms])
    </tbody>
</table>
