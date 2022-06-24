<?php

namespace App\Http\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;

class MultiSelect extends Component
{
    public $mainModel;

    public $optionsModel;

    public $options;

    public $selected;

    public $descriptors;

    public $eventName;

    public $index;

    public function mount($mainModel, $optionsModel, $selected, $descriptors, $index)
    {
        $this->mainModel = [
            'title' => $mainModel,
            'plural' => Str::lower(Str::plural($mainModel)),
            'namespace' => "\\App\\Models\\$mainModel",
        ];
        $this->optionsModel = [
            'title' => $optionsModel,
            'plural' => Str::lower(Str::plural($optionsModel)),
            'namespace' => "\\App\\Models\\$optionsModel",
            'columns' => Arr::except(Schema::getColumnListing(app("\\App\\Models\\$optionsModel")->getTable()), ['created_at', 'updated_at', 'deleted_at']),
        ];
        $this->options = $this->optionsModel['namespace']::get();
        $this->selected = $this->optionsModel['namespace']::find($selected);
        $this->descriptors = $descriptors;
        $this->eventName = 'update'.Str::ucfirst($this->mainModel['title']).Str::ucfirst($this->optionsModel['plural']);
        $this->index = $index;
    }

    public function render()
    {
        return view('livewire.multi-select');
    }

    public function selectedArray()
    {
        return $this->selected->toArray();
    }

    public function update($optionId)
    {
        if ($this->selected->contains($optionId)) {
            $this->selected = $this->selected->filter(function ($value) use ($optionId) {
                return $value->id != $optionId;
            });
        } else {
            $this->selected->push($this->optionsModel['namespace']::find($optionId));
        }
        $this->selected->sortBy($this->descriptors[0]);

        $this->emit($this->eventName, $this->selected->pluck('id'), $this->index);
    }
}
