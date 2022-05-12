<?php

namespace App\Http\Livewire\Report;

use App\Models\Form;
use Livewire\Component;

class Expiring extends Component
{
    public $expiresInDays = 30;
    public $filter = '';

    protected $queryString = ['expiresInDays', 'filter'];

    public function render()
    {
        return view('livewire.report.expiring', [
            'forms' => $this->getExpiringForms(),
        ]);
    }

    protected function getExpiringForms()
    {
        return Form::where('review_date', '<=', now()->addDays($this->expiresInDays))
            ->where('review_date', '>=', now())
            ->when(strlen(trim($this->filter)) > 2, function ($query) {
                $query->where(function ($query) {
                    $query->where('title', 'like', "%{$this->filter}%")
                        ->orWhere('location', 'like', "%{$this->filter}%")
                        ->orWhere('description', 'like', "%{$this->filter}%")
                        ->orWhere('management_unit', 'like', "%{$this->filter}%");
                });
            })
            ->with(['user', 'supervisor'])
            ->orderBy('review_date', 'asc')
            ->get();
    }
}
