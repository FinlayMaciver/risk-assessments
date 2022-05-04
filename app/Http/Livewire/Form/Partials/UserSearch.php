<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;

class UserSearch extends Component
{
    public $user;

    public $email;

    public $valid;

    public $index;

    public function mount($user, $index = null)
    {
        $this->index = $index;
        if (isset($user->email)) {
            $this->email = $user->email;
            $this->valid = true;
        }
    }

    public function render()
    {
        return view('livewire.form.partials.user-search');
    }

    public function delete()
    {
        $this->emit('userDeleted', $this->user, $this->index);
    }

    public function search()
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            $this->user = $user;
            $this->emit('userUpdated', $this->user, $this->index);

            return $this->valid = true;
        }

        $search = \Ldap::findUserByEmail($this->email);
        if ($search) {
            $user = User::create([
                'forenames' => $search['forenames'],
                'surname' => $search['surname'],
                'guid' => $search['username'],
                'email' => $search['email'],
            ]);
            $this->emit('userUpdated', $this->user, $this->index);

            return $this->valid = true;
        }

        return $this->valid = false;
    }
}
