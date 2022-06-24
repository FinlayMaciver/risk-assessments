<?php

namespace App\Http\Livewire\Report;

use App\Http\Livewire\Concerns\CanFilterForms;
use App\Models\Form;
use Livewire\Component;

class Expiring extends Component
{
    use CanFilterForms;

    public function render()
    {
        return view('livewire.report.expiring', [
            'forms' => $this->findAllMatchingForms(),
        ]);
    }
}
