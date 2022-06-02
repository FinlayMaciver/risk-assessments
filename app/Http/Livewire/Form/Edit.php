<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
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
    }

    public function render()
    {
        return view('livewire.form.edit');
    }
}
