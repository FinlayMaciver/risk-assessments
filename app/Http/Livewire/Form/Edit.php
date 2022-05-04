<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use Livewire\Component;

class Edit extends Component
{
    public $formId;

    public Form $form;

    public function mount()
    {
        $this->form = Form::with('substances.hazards')->findOrFail($this->formId);
    }

    public function render()
    {
        return view('livewire.form.edit');
    }
}
