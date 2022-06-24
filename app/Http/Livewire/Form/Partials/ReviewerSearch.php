<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\User;
use Livewire\Component;

class ReviewerSearch extends Component
{
    public $reviewer;
    public $email;
    public $valid;
    public $index;

    public function mount($reviewer, $index = null)
    {
        $this->index = $index;
        if (isset($reviewer->email)) {
            $this->email = $reviewer->email;
            $this->valid = true;
        }
    }

    public function render()
    {
        return view('livewire.form.partials.reviewer-search');
    }

    public function delete()
    {
        $this->emit('reviewerDeleted', $this->reviewer, $this->index);
    }

    public function search()
    {
        $reviewer = User::where('email', $this->email)->first();
        if ($reviewer) {
            $this->reviewer = $reviewer;
            $this->emit('reviewerUpdated', $this->reviewer, $this->index);

            return $this->valid = true;
        }

        $search = \Ldap::findUserByEmail($this->email);
        if ($search) {
            $reviewer = User::create([
                'forenames' => $search['forenames'],
                'surname' => $search['surname'],
                'guid' => $search['username'],
                'email' => $search['email'],
            ]);
            $this->emit('reviewerUpdated', $this->reviewer, $this->index);

            return $this->valid = true;
        }

        return $this->valid = false;
    }
}
