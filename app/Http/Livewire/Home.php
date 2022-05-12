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

    public $myForms;
    public $search = '';
    public $statusFilter = '';
    public $multiFilter = '';
    public $orderBy = [
        'column' => 'forms.created_at',
        'order' => 'asc',
    ];

    public function render()
    {
        $this->myForms = Form::where('user_id', Auth::user()->id)
            ->when(
                $this->statusFilter !== '',
                fn ($query) => $query->where('status', $this->statusFilter)
            )
            ->when(
                $this->multiFilter !== '',
                fn ($query) => $query->where('multi_user', $this->multiFilter)
            )
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


        return view('livewire.home');
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
