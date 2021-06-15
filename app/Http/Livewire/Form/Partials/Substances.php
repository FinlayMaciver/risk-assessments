<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\FormSubstance;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Substances extends Component
{
    public Collection $substances;

    protected $rules = [
        'substances.*.substance' => 'string',
        'substances.*.quantity' => 'string',
        'substances.*.route' => 'string',
        'substances.*.single_acute_effect' => 'string',
        'substances.*.repeated_low_effect' => 'string',
        'substances.*.hazards' => '',
    ];

    public function render()
    {
        return view('livewire.form.partials.substances');
    }

    public function add()
    {
        $this->substances[] = new FormSubstance();
    }

    public function delete($index)
    {
        $this->substances->forget($index);
        $this->update();
    }

    public function update()
    {
        $this->emit('substancesUpdated', $this->substances);
    }
}
