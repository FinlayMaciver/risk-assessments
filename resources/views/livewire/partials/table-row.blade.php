@foreach ($forms as $form)
<tr>
    <td class="d-block d-md-table-cell">
    @if ($form->status == 'Approved')
            <span class="badge bg-success fw-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $form->status }}">
                <span class="icon-spacing">
                    <i class="fas fa-check"></i>
                </span>
            </span>
        @elseif ($form->status == 'Rejected')
            <span class="badge bg-danger fw-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $form->status }}">
                <span class="icon-spacing">
                    <i class="fas fa-times"></i>
                </span>
            </span>
        @elseif ($form->status == 'Pending')
            <span class="badge bg-info fw-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $form->status }}">
                <span class="icon-spacing">
                    <i class="fas fa-hourglass-half"></i>
                </span>
            </span>
        @endif
        <a title="{{$form->title}}" data-toggle="tooltip" data-placement="top" href="{{ route('form.show', $form->id) }}">{{ Str::limit($form->title, 70, "(...)") }}</a>
    </td>
    <td title="{{$form->title}}" data-toggle="tooltip" data-placement="top" class="d-none d-md-table-cell">{{ Str::limit($form->location, 50, "(...)") }}</td>
    <td class="d-none d-md-table-cell">{{ $form->created_at }}</td>
    <td class="d-none d-md-table-cell">{{ $form->formatted_updated_at }}</td>
    <td class="d-none d-md-table-cell">{{ $form->user->forenames }} {{ $form->user->surname }}</td>
</tr>
@endforeach
