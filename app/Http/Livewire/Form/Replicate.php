<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use Livewire\Component;

class Replicate extends Component
{
    public Form $form;

    public function mount($id)
    {
        $originalForm = Form::with([
            'coshhSection',
            'risks',
            'substances.routes',
            'substances.hazards',
            'microOrganisms.routes',
            'files',
        ])->findOrFail($id);

        $this->form = $originalForm;
        unset($this->form->id);
        unset($this->form->review_date);
        unset($this->form->supervisor_id);
        $this->form->user_id = auth()->user()->id;
        if ($this->form->coshhSection) {
            unset($this->form->coshhSection->id);
            unset($this->form->coshhSection->form_id);
        }
        if ($this->form->risks) {
            $this->form->risks->each(function ($risk) {
                unset($risk->id);
                unset($risk->form_id);
            });
        }
        if ($this->form->substances) {
            $this->form->substances->each(function ($substance) {
                unset($substance->id);
                unset($substance->form_id);
            });
            $this->form->substances->each(function ($substance) {
                unset($substance->id);
                unset($substance->form_id);
            });
        }
        if ($this->form->microOrganisms) {
            $this->form->microOrganisms->each(function ($microOrganism) {
                unset($microOrganism->id);
                unset($microOrganism->form_id);
            });
        }
        if ($this->form->files) {
            $this->form->files->each(function ($file) {
                unset($file->id);
                unset($file->form_id);
            });
        }
    }

    public function render()
    {
        return view('livewire.form.edit');
    }
}
