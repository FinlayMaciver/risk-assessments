<div class="row justify-content-center">
    <div class="col col-lg-9 mt-3">
        <div class="d-grid d-md-block dropdown mb-2 float-end">
            <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                + Create
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a class="dropdown-item" href="{{ route('form.create', [
                        'type' => 'General'
                    ]) }}">General</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('form.create', [
                        'type' => 'Chemical'
                    ]) }}">Chemical</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('form.create', [
                        'type' => 'Biological'
                    ]) }}">Biological</a>
                </li>
            </ul>
        </div>

        <table class="table table-borderless border rounded-3">
            <thead class="table-light">
                <tr>
                    @if (! $forms->count())
                        <td class="text-center fw-bold" colspan="3">You have not submitted any forms.</td>
                    @else
                    <th class="d-none d-md-table-cell">Title</th>
                    <th class="d-none d-md-table-cell">Location</th>
                    <th class="d-none d-md-table-cell">Uploaded</th>
                    <th class="d-none d-md-table-cell">Updated</th>
                    <th class="d-none d-md-table-cell">Status</th>
                </tr>
                @endif
            </thead>
            <tbody class="border">
                @foreach ($forms as $form)
                <tr>
                    <td class="d-block d-md-table-cell"><a href="{{ route('form.show', $form->id) }}">{{ $form->title }}</a></td>
                    <td class="d-none d-md-table-cell">{{ $form->location }}</td>
                    <td class="d-none d-md-table-cell">{{ $form->formatted_created_at }}</td>
                    <td class="d-none d-md-table-cell">{{ $form->formatted_updated_at }}</td>
                    <td class="d-block d-md-table-cell">
                        @if ($form->status == 'Approved')
                            <span class="badge bg-success fw-bold">
                                <span class="icon-spacing">
                                    <i class="fas fa-check"></i>
                                </span>
                                {{ $form->status }}
                            </span>
                        @elseif ($form->status == 'Denied')
                            <span class="badge bg-danger fw-bold">
                                <span class="icon-spacing">
                                    <i class="fas fa-times"></i>
                                </span>
                                {{ $form->status }}
                            </span>
                        @elseif ($form->status == 'Pending')
                            <span class="badge bg-warning fw-bold">
                                <span class="icon-spacing">
                                    <i class="far fa-clock"></i>
                                </span>
                                {{ $form->status }}
                            </span>
                        @else
                            {{ $form->status }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
