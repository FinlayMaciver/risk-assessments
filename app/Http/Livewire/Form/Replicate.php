<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use Livewire\Component;

class Replicate extends Component
{
    public Form $form;

    public function mount($id)
    {
        $this->form = Form::with([
            'coshhSection',
            'risks',
            'substances.routes',
            'substances.hazards',
            'microOrganisms.routes',
            'files',
        ])->findOrFail($id);
        $this->form->id = null;
        $this->form->review_date = null;
        $this->form->user_id = auth()->user()->id;
        $this->form->supervisor_id = null;
        if ($this->form->coshhSection) {
            $this->form->coshhSection->id = null;
        }
        if ($this->form->risks) {
            $this->form->risks->each(fn ($risk) => $risk->id = null);
        }
        if ($this->form->substances) {
            $this->form->substances->each(fn ($substance) => $substance->id = null);
        }
        if ($this->form->microOrganisms) {
            $this->form->microOrganisms->each(fn ($microOrganism) => $microOrganism->id = null);
        }
        if ($this->form->files) {
            $this->form->files->each(fn ($file) => $file->id = null);
        }
    }

    public function render()
    {
        return view('livewire.form.edit');
    }
}
