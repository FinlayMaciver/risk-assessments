<?php

namespace App\Http\Livewire;

use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\Concerns\CanFilterForms;

class AllForms extends Component
{
    use WithPagination;
    use CanFilterForms;

    public function render()
    {
        return view('livewire.all-forms', [
            'allForms' => $this->findAllMatchingForms(),
        ]);
    }
}
