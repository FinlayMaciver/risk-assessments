<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use App\Models\GeneralFormDetails;
use App\Models\Risk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public Form $form;

    public function mount($type = null)
    {
        $this->form = Form::make([
            'type' => $type,
            'user_id' => Auth::user()->id,
        ]);
    }

    public function render()
    {
        return view('livewire.form.create');
    }
}
