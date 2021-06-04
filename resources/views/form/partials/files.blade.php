<div class="card">
    <div class="card-header fw-bold">Attach documents (e.g. MSDS's)</div>
    <div class="card-body">
        @if ($form['files'])
            @foreach($form['files'] as $index => $file)
                <div class="d-inline d-lg-inline-block w-25 me-3 mb-3">
                    <div class="p-3 border border-2 rounded-2 shadow border-success text-center text-success">
                        <i class="fas fa-4x fa-file-upload mb-2"></i>
                        <h6>{{  $file->original_filename }}<br>
                        ({{ App\Models\FormFile::bytesConversion($file->size) }})
                    </h6>
                    </div>
                </div>
            @endforeach
            <hr>
        @endif
        @if ($newFiles)
            <div class="text-center">
            @foreach($newFiles as $index => $file)
                <div class="d-inline d-lg-inline-block w-25 me-3 mb-3">
                    <div class="p-3 border border-2 rounded-2 shadow border-success text-center text-success">
                        <i class="fas fa-4x fa-file-upload mb-2"></i>
                        <h6>{{  $file->getClientOriginalName() }}<br>
                        ({{ App\Models\FormFile::bytesConversion($file->getSize()) }})
                    </h6>
                    </div>
                </div>
            @endforeach
            </div>
            <hr>
        @endif
        <div class="d-grid">
            <label class="btn btn-outline-info custom-input-btn">
                <input type="file" wire:model="newFiles" style="display:none">
                <i class="fas fa-upload"></i> Add a file
            </label>
        </div>
    </div>
</div>
<br>
