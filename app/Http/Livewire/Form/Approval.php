<?php

namespace App\Http\Livewire\Form;

use App\Models\Form;
use Livewire\Component;

class Approval extends Component
{
    public Form $form;
    public $comments;

    public function render()
    {
        return view('livewire.form.approval');
    }

    public function submit($verdict)
    {
        if ($this->form->supervisor == auth()->user()) {
            $this->form->supervisorApproval($verdict, $this->comments);
        } elseif ($this->form->labGuardian == auth()->user()) {
            $this->form->labGuardianApproval($verdict, $this->comments);
        } elseif (auth()->user()->is_coshh_admin) {
            $this->form->coshhAdminApproval($verdict, $this->comments);
        }

        session()->flash('success_message', 'Submitted verdict.');
        return redirect()->route('form.show', $this->form->id);
    }
}
