<?php

namespace App\Http\Livewire;

use App\Models\Form;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'forms' => Form::where('user_id', Auth::user()->id)->get()
        ]);
    }
}
