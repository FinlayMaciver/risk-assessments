<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\Substance;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Substances extends Component
{
    public Collection $substances;

    protected $listeners = [
        'updateHazards',
        'updateRoutes'
    ];

    protected $rules = [
        'substances.*.substance' => 'string',
        'substances.*.quantity' => 'string',
        'substances.*.single_acute_effect' => 'string',
        'substances.*.repeated_low_effect' => 'string',
        'substances.*.hazard_ids' => '',
        'substances.*.route_ids' => '',
    ];

    public function render()
    {
        return view('livewire.form.partials.substances');
    }

    public function add()
    {
        $this->substances[] = new Substance();
    }

    public function delete($index)
    {
        $this->substances->forget($index);
        $this->update();
    }

    public function updateHazards($ids, $index)
    {
        $this->substances[$index]->hazard_ids = $ids;
        $this->update();
    }

    public function updateRoutes($ids, $index)
    {
        $this->substances[$index]->route_ids = $ids;
        $this->update();
    }

    public function update()
    {
        $this->emit('substancesUpdated', $this->substances);
    }
}
