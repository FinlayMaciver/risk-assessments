<?php

namespace App\Http\Livewire;

use App\Models\Form;
use Livewire\Component;

class SignedForms extends Component
{
    public $signedForms;
    public $search = '';
    public $orderBy = [
        'column' => 'forms.created_at',
        'order' => 'asc',
    ];

    public function render()
    {
        $this->signedForms = Form::with('users')
            ->whereHas('users', fn ($q) => $q->where('user_id', auth()->user()->id))
            ->when(
                $this->search !== '',
                fn ($query) => $query->where(
                    fn ($query) => $query->where('title', 'like', "%$this->search%")
                    ->orWhere('location', 'like', "%$this->search%")
                    ->orWhere('status', 'like', "%$this->search%")
                    ->orWhereHas('user', function ($query) {
                        return $query->whereRaw("CONCAT(`forenames`, ' ', `surname`) LIKE ?", ["%$this->search%"]);
                    })
                )
            )->orderBy(
                $this->orderBy['column'],
                $this->orderBy['order']
            )->get();

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
