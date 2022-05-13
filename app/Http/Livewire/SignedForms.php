<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\CanFilterForms;
use App\Models\Form;
use Livewire\Component;

class SignedForms extends Component
{
    use CanFilterForms;

    public function render()
    {
        return view('livewire.signed-forms', [
            'signedForms' => $this->findAllMatchingForms(),
        ]);
    }
}
