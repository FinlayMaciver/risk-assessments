<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use App\Models\FormRisk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $type;
    public $form;

    public function mount($multiUser = false)
    {
        $this->form = new Form([
            'type' => $this->type,
            'user_id' => Auth::user()->id,
            'multi_user' => $multiUser
        ]);

        $this->form->risks->add(new FormRisk());
    }

    public function render()
    {
        return view('livewire.form.create');
    }
}
