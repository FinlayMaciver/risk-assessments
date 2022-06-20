<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\CanFilterForms;
use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;

class ArchivedForms extends Component
{
    use WithPagination;
    use CanFilterForms;

    public function render()
    {
        return view('livewire.archived-forms', [
            'forms' => Form::with('user')->archived()->get(),
        ]);
    }
}
