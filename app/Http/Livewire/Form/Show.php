<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use Livewire\Component;

class Show extends Component
{
    public $form;

    public function mount($id)
    {
        $this->form = Form::with([
            'user',
            'supervisor',
            'coshhSection',
            'risks.likelihoodWith',
            'risks.likelihoodWithout',
            'risks.impactWith',
            'risks.impactWithout',
            'substances.routes',
            'substances.hazards',
            'microOrganisms.routes',
            'files',
        ])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.form.show');
    }
}
