<div class="row justify-content-center mb-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center fw-bold">Approval</div>
            <div class="card-body">
                <p>
                    <span class="fw-bold">Would you like to provide comments? (Please give reasoning if your reject the form).</span><br>
                    <textarea wire:model="comments" name="comments" class="form-control"></textarea>
                    <div class="d-grid d-md-block gap-1">
                        <button wire:click.prevent="submit(true)" class="btn btn-success">Approve</button>
                        <button wire:click.prevent="submit(false)" class="btn btn-danger float-md-end">Reject</button>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>
