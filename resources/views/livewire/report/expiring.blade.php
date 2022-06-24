<div class="row justify-content-center">
    <div class="col mt-3">
        <h2 class="mt-5 mb-5 text-center">Expiring Risk Assessments</h2>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label class="col-form-label" for="expires-in-days">Expires in the next (days)</label>
                      <input wire:model="expiresInDays" type="number" class="form-control" id="expires-in-days" aria-label="Expiring in (days)">
                    </div>
                    <div class="col">
                        <label class="col-form-label" for="filter">Search...</label>
                      <input wire:model="search" id="filter" type="text" class="form-control" placeholder="Search..." aria-label="Last name">
                    </div>
                </div>
                <hr />
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Management Unit</th>
                                <th>Location</th>
                                <th>Review Date</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Reviewer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($forms as $form)
                                <tr id="form-row-{{ $form->id }}">
                                    <td>
                                        <a href="{{ route('form.show', $form->id) }}">{{ str($form->title)->substr(0, 32) }}</a>
                                    </td>
                                    <td>{{ $form->management_unit }}</td>
                                    <td>{{ $form->location }}</td>
                                    <td>{{ $form->review_date?->format('d/m/Y') }}</td>
                                    <td>{{ $form->type }}</td>
                                    <td>{{ $form->status }}</td>
                                    <td>{{ $form->user?->full_name }}</td>
                                    <td>{{ $form->supervisor?->full_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
