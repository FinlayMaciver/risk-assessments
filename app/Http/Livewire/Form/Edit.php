<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Edit extends Component
{
    public Form $form;

    public function mount($id)
    {
        $this->form = Form::with(
            'user',
            'supervisor',
            'coshhSection',
            'risks',
            'substances.routes',
            'substances.hazards',
            'microOrganisms.routes',
            'files',
        )->findOrFail($id);

        if (! Gate::allows('edit-form', $this->form)) {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.form.edit');
    }
}
