<?php

namespace App\Http\Livewire;

use App\Models\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $orderBy = [
        'column' => 'forms.created_at',
        'order' => 'asc'
    ];

    public function render()
    {
        $forms = Form::with('user')->join('users', 'forms.user_id', '=', 'users.id')
            ->when(
                $this->statusFilter !== '',
                fn ($query) => $query->where('status', $this->statusFilter)
            )
            ->when(
                $this->search !== '',
                fn ($query) => $query->where(
                    fn ($query) => $query->where('title', 'like', "%$this->search%")
                ->orWhere('location', 'like', "%$this->search%")
                ->orWhere('status', 'like', "%$this->search%")
                ->orWhere(DB::raw("CONCAT(`forenames`, ' ', `surname`)"), 'like', "%$this->search%")
                )
            )->orderBy(
                $this->orderBy['column'],
                $this->orderBy['order']
            );
        return view('livewire.home', [
            'allForms' => $forms->get(),
            'myForms' => $forms->where('user_id', Auth::user()->id)->get(),
        ]);
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
