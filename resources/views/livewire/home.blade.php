<div class="row justify-content-center">
    <div class="col col-lg-9 mt-3">
        <div class="d-grid d-md-block dropdown mb-2 float-end">
            <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                + Create
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                <li><h6 class="dropdown-header">Single User</h6></li>
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
                        'type' => 'General'
                    ]) }}">Biological</a>
                </li>
                <hr>
                <li><h6 class="dropdown-header">Multi User</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('form.create', [
                        'type' => 'General',
                        'multiUser' => true
                    ]) }}">General</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('form.create', [
                        'type' => 'Chemical',
                        'multiUser' => true
                    ]) }}">Chemical</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('form.create', [
                        'type' => 'Biological',
                        'multiUser' => true
                    ]) }}">Biological</a>
                </li>
            </ul>
        </div>

        <table class="table table-borderless border rounded-3">
            <thead class="table-light">
                <tr>
                    @if (! $forms->count())
                        <td class="text-center font-weight-bold" colspan="3">You have not submitted any forms.</td>
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
                    <td class="d-block d-md-table-cell">{{ $form->title }}</td>
                    <td class="d-none d-md-table-cell">{{ $form->location }}</td>
                    <td class="d-none d-md-table-cell">{{ $form->created_at }}</td>
                    <td class="d-none d-md-table-cell">{{ $form->updated_at }}</td>
                    <td class="d-block d-md-table-cell">
                        @if ($form->status == 'Approved')
                            <span class="text-success font-weight-bold fw-bold">
                                <span class="icon-spacing">
                                    <i class="fas fa-check"></i>
                                </span>
                                {{ $form->status }}
                            </span>
                        @elseif ($form->status == 'Denied')
                            <span class="text-danger font-weight-bold fw-bold">
                                <span class="icon-spacing">
                                    <i class="fas fa-times"></i>
                                </span>
                                {{ $form->status }}
                            </span>
                        @elseif ($form->status == 'Pending')
                             <span class="text-warning font-weight-bold fw-bold">
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
