<?php

namespace App\Http\Livewire\Report;

use App\Models\Form;
use Livewire\Component;

class Expiring extends Component
{
    public $expiresInDays = 30;

    public function render()
    {
        return view('livewire.report.expiring', [
            'forms' => $this->getExpiringForms(),
        ]);
    }

    protected function getExpiringForms()
    {
        return Form::where('review_date', '<', now()->addDays($this->expiresInDays))
            ->with(['user', 'supervisor'])
            ->orderBy('review_date', 'asc')
            ->get();
    }
}
