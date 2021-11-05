<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use Livewire\Component;

class Edit extends Component
{
    public $id;
    public Form $form;

    public function mount()
    {
        $this->form = Form::with('substances.hazards')->findOrFail($this->id);
    }

    public function render()
    {
        return view('livewire.form.edit');
    }
}
