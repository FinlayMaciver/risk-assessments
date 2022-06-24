<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\CanFilterForms;
use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    use CanFilterForms;

    public function mount()
    {
        $this->authUserOnly = 1;
    }

    public function render()
    {
        return view('livewire.home', [
            'forms' => $this->findAllMatchingForms(),
            'formsAwaitingApproval' => Form::current()->with('reviewers', 'user')
                ->awaitingReviewerApprovalFrom(auth()->user())
                ->orWhere(fn ($q) => $q->awaitingSupervisorApprovalFrom(auth()->user()))
                ->get(),
        ]);
    }
}
