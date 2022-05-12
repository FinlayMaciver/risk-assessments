<?php

namespace App\Http\Livewire;

use App\Models\Form;
use Livewire\Component;

class AllForms extends Component
{
    public $allForms;
    public $search = '';
    public $statusFilter = '';
    public $multiFilter = '';
    public $orderBy = [
        'column' => 'forms.created_at',
        'order' => 'asc',
    ];

    public function mount()
    {
        $this->allForms = Form::with('user')->get();
    }

    public function render()
    {
        return view('livewire.all-forms');
    }

    public function toggleSort($column)
    {
        $this->resetPage();
        if ($this->orderBy['column'] == $column) {
            $this->orderBy['order'] = $this->orderBy['order'] == 'asc' ? 'desc' : 'asc';
        } else {
            $this->orderBy['column'] = $column;
            $this->orderBy['order'] = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
