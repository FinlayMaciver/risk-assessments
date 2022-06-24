@foreach ($forms as $form)
<tr id="form-row-{{ $form->id }}">
    <td class="d-block d-md-table-cell">
        <a title="{{$form->title}}" data-toggle="tooltip" data-placement="top" href="{{ route('form.show', $form->id) }}">{{ Str::limit($form->title, 70, "(...)") }}</a>
    </td>
    <td title="{{$form->title}}" data-toggle="tooltip" data-placement="top" class="d-none d-md-table-cell">{{ Str::limit($form->location, 50, "(...)") }}</td>
    <td class="d-none d-md-table-cell">{{ $form->formatted_created_at }}</td>
    <td class="d-none d-md-table-cell">{{ $form->formatted_updated_at }}</td>
    <td class="d-none d-md-table-cell">{{ $form->user->forenames }} {{ $form->user->surname }}</td>
    <td class="d-block d-md-table-cell">
        @if ($form->is_archived)
            <span class="badge bg-secondary fw-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="Archived">
                <span class="icon-spacing">
                    <i class="fa-solid fa-lock"></i>
                </span>
                Archived
            </span>
        @elseif ($form->status == 'Approved')
            <span class="badge bg-success fw-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $form->status }}">
                <span class="icon-spacing">
                    <i class="fa-solid fa-check"></i>
                </span>
                Approved
            </span>
        @elseif ($form->status == 'Rejected')
            <span class="badge bg-danger fw-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $form->status }}">
                <span class="icon-spacing">
                    <i class="fa-solid fa-times"></i>
                </span>
                Rejected
            </span>
        @elseif ($form->status == 'Pending')
            <span class="badge bg-info fw-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $form->status }}">
                <span class="icon-spacing">
                    <i class="fa-solid fa-hourglass-half"></i>
                </span>
                Pending
            </span>
        @endif
    </td>
</tr>
@endforeach
