<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\FormRisk;
use Livewire\Component;

class Risks extends Component
{
    public $risks;

    protected $listeners = [
        'validate' => 'validateRisks'
    ];

    protected $rules = [
        'risks.*.description' => 'string',
        'risks.*.severity' => 'required_with:risks.*.description|string',
        'risks.*.control_measures' => 'required_with:risks.*.description|string',
        'risks.*.likelihood_with' => 'required_with:risks.*.description|string',
        'risks.*.likelihood_without' => 'required_with:risks.*.description|string',
    ];

    public function render()
    {
        return view('livewire.form.partials.risks');
    }

    public function validateRisks()
    {
        // dd('hiya');
        $v = $this->validate();
        dd($v);
    }

    public function add()
    {
        $this->risks[] = new FormRisk();
    }

    public function update()
    {
        $this->emit('riskChanged', $this->risks);
    }
}
