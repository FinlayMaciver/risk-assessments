<div class="card">
    <div class="card-header fw-bold">Attach documents (e.g. MSDS's)</div>
    <div class="card-body text-center">
        @foreach($form->files as $index => $file)
            <div class="d-inline d-lg-inline-block w-25 me-3 mb-3">
                <div class="p-3 border border-2 rounded-2 shadow border-success text-center text-primary">
                    <i class="fas fa-4x fa-file-alt mb-2"></i>
                    <h6>{{  $file->original_filename }}<br>
                    ({{ App\Models\File::bytesConversion($file->size) }})
                </h6>
                </div>
            </div>
        @endforeach
        <hr>
        @foreach($newFiles as $index => $file)
            <div class="d-inline d-lg-inline-block w-25 me-3 mb-3">
                <div class="p-3 border border-2 rounded-2 shadow border-success text-center text-success">
                    <i class="fas fa-4x fa-file-upload mb-2"></i>
                    <h6>{{  $file->getClientOriginalName() }}<br>
                    ({{ App\Models\File::bytesConversion($file->getSize()) }})
                </h6>
                </div>
            </div>
        @endforeach
        <div class="d-grid">
            <label class="btn btn-outline-info custom-input-btn">
                <input type="file" wire:model="newFiles" style="display:none" multiple>
                <i class="fas fa-upload"></i> @if ($newFiles) Change new files @else Add files @endif
            </label>
        </div>
    </div>
</div>
