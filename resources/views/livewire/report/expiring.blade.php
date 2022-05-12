<div class="row justify-content-center">
    <div class="col mt-3">
        <h2 class="text-center">Expiring Risk Assessments</h2>
        <hr />
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
                    <tr>
                        <td>{{ $form->title }}</td>
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
