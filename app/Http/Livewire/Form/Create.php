<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use App\Models\FormRisk;
use App\Models\GeneralFormDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public Form $form;

    public function mount($type = null, $multiUser = false)
    {
        $this->form = Form::make([
            'type' => $type,
            'user_id' => Auth::user()->id,
            'multi_user' => $multiUser
        ]);
    }

    public function render()
    {
        return view('livewire.form.create');
    }
}
