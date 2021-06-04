<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use Livewire\Component;

class Edit extends Component
{
    public $formId;
    public $form = [];

    public function mount()
    {
        $form = Form::findOrFail($this->formId);
        $this->form = $form->toArray();
        $this->form['risks'] = $form->risks->toArray();
        $this->form['files'] = $form->files->toArray();
        if ($form->type == 'General') {
            $this->form['general'] = $form->general->toArray();
        }
    }

    public function render()
    {
        return view('livewire.form.edit');
    }
}
