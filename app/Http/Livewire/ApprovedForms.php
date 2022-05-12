<?php

namespace App\Http\Livewire;

use App\Models\Form;
use Livewire\Component;

class ApprovedForms extends Component
{
    public $approvedForms;
    public $search = '';
    public $statusFilter = '';
    public $multiFilter = '';
    public $orderBy = [
        'column' => 'forms.created_at',
        'order' => 'asc',
    ];

    public function mount()
    {
        $this->approvedForms = Form::with('reviewers')
            ->whereHas('reviewers', fn ($q) => $q->where('user_id', auth()->user()->id))
            ->orWhere('supervisor_id', auth()->user()->id)->get();
    }

    public function render()
    {
        return view('livewire.approved-forms');
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
