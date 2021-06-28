<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\Risk;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Risks extends Component
{
    public Collection $risks;

    protected $rules = [
        'risks.*.description' => 'string',
        'risks.*.severity' => 'string',
        'risks.*.control_measures' => 'string',
        'risks.*.likelihood_with' => 'string',
        'risks.*.likelihood_without' => 'string',
    ];

    public function render()
    {
        return view('livewire.form.partials.risks');
    }

    public function add()
    {
        $this->risks[] = new Risk();
    }

    public function delete($index)
    {
        $this->risks->forget($index);
        $this->update();
    }

    public function update()
    {
        $this->emit('risksUpdated', $this->risks);
    }
}
