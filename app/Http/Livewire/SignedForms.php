<?php

namespace App\Http\Livewire;

use App\Models\Form;
use Livewire\Component;

class SignedForms extends Component
{
    public $signedForms;
    public $search = '';
    public $statusFilter = '';
    public $multiFilter = '';
    public $orderBy = [
        'column' => 'forms.created_at',
        'order' => 'asc',
    ];

    public function mount()
    {
        $this->signedForms = Form::with('users')
            ->whereHas('users', fn ($q) => $q->where('user_id', auth()->user()->id))->get();
    }

    public function render()
    {
        return view('livewire.signed-forms');
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
