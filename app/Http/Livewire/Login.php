<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public $guid = '';

    public $password = '';

    public $remember = '';

    public function render()
    {
        return view('livewire.login');
    }

    public function login()
    {
        $this->validate([
            'guid' => 'required',
            'password' => 'required',
        ]);

        if (config('ldap.authentication')) {
            if (! \Ldap::authenticate($this->guid, $this->password)) {
                throw ValidationException::withMessages([
                    'authentication' => 'You have entered an invalid GUID or password',
                ]);
            }
        }

        $user = User::where('guid', $this->guid)->first();
        if (! $user) {
            $user = User::createFromLdap($this->guid);
        }

        Auth::login($user, $this->remember);

        return redirect(route('home'));
    }
}
