<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;

class UserSearch extends Component
{
    public $type;
    public $user;
    public $email;
    public $valid;

    public function mount($user)
    {
        if ($user) {
            $this->email = $user->email;
            $this->valid = true;
        }
    }

    public function render()
    {
        return view('livewire.form.partials.user-search');
    }

    public function search()
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            $this->user = $user;
            $this->emit(Str::camel("$this->type Updated"), $this->user);
            return $this->valid = true;
        }

        $search = \Ldap::findUserByEmail($this->email);
        if ($search) {
            $user = User::create([
                'forenames' => $search['forenames'],
                'surname' => $search['surname'],
                'guid' => $search['guid'],
                'email' => $search['email'],
            ]);
            $this->emit(Str::camel("$this->type Updated"), $this->user);
            return $this->valid = true;
        }
        return $this->valid = false;
    }
}
