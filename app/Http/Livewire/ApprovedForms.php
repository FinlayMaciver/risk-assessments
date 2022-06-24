<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\CanFilterForms;
use App\Models\Form;
use Livewire\Component;

class ApprovedForms extends Component
{
    use CanFilterForms;

    public function render()
    {
        return view('livewire.approved-forms', [
            'forms' => $this->findAllMatchingForms(),
        ]);
    }
}
