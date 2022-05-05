<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public Form $form;

    public function mount($type = null)
    {
        $this->form = Form::make([
            'type' => 'General',
            'user_id' => Auth::user()->id,
        ]);
    }

    public function render()
    {
        return view('livewire.form.create');
    }
}
