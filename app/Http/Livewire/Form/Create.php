<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use App\Models\FormRisk;
use App\Models\GeneralFormDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $form;

    public function mount($type = null, $multiUser = false)
    {
        $this->form = Form::make([
            'type' => $type,
            'user_id' => Auth::user()->id,
            'multi_user' => $multiUser
        ])->toArray();

        $this->form['files'] = [];
        $this->form['risks'][] = new FormRisk();
        if ($type == 'General') {
            $this->form['general'] = GeneralFormDetails::make()->toArray();
        }
    }

    public function render()
    {
        return view('livewire.form.create');
    }
}
